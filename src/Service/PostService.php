<?php

namespace App\Service;

use App\DBAL\Types\ContentStatusType;
use App\Entity\Comment;
use App\Entity\Post;
use App\Form\CommentType;
use App\Repository\CategoryRepository;
use App\Repository\PageRepository;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\RouterInterface;

/**
 * The Post service
 *
 * @package App\Service
 */
class PostService
{
    /** @var PostRepository The post repository. */
    private $postRepository;

    /** @var PageRepository The page repository. */
    private $pageRepository;

    /** @var CategoryRepository The category repository. */
    private $categoryRepository;

    /** @var PaginatorInterface The paginator service */
    private $paginator;

    /** @var RouterInterface The router. */
    private $router;

    /** @var FormFactoryInterface The form factory. */
    private $formFactory;

    /** @var EntityManagerInterface The entity manager. */
    private $entityManager;

    /**
     * Create the post service.
     *
     * @param PostRepository $postRepository The post repository.
     * @param PageRepository $pageRepository The page repository.
     * @param CategoryRepository $categoryRepository The category repository.
     * @param PaginatorInterface $paginator The paginator interface.
     * @param RouterInterface $router The router.
     * @param FormFactoryInterface $formFactory The form factory.
     * @param EntityManagerInterface $entityManager The entity manager.
     */
    public function __construct(PostRepository $postRepository, PageRepository $pageRepository,
                                CategoryRepository $categoryRepository, PaginatorInterface $paginator,
                                RouterInterface $router, FormFactoryInterface $formFactory,
                                EntityManagerInterface $entityManager)
    {
        $this->postRepository = $postRepository;
        $this->pageRepository = $pageRepository;
        $this->categoryRepository = $categoryRepository;
        $this->paginator = $paginator;
        $this->router = $router;
        $this->formFactory = $formFactory;
        $this->entityManager = $entityManager;
    }

    /**
     * Return a post list page.
     *
     * @param int $page The page number.
     * @param int|null $year The year of the posts to include. If null, fetch all posts.
     * @param int|null $month The month of the posts to include. If null, fetch all posts in the year.
     * @param int|null $day The day of the posts to include. If null, fetch all posts in the month.
     * @return array The model for the page.
     * @throws \Exception
     */
    public function list(int $page = 1, int $year = null, int $month = null, int $day = null): array
    {
        // Fetch contents by publication date
        $queryBuilder = $this->postRepository->createQueryBuilder('p');
        list($startDate, $endDate) = $this->getStartEnd($year, $month, $day);

        if ($startDate !== null && $endDate != null) {
            $queryBuilder->andWhere(
                $queryBuilder->expr()->andX(
                    $queryBuilder->expr()->gte('p.publishedAt', ':startDate'),
                    $queryBuilder->expr()->lt('p.publishedAt', ':endDate')
                )
            );
            $queryBuilder->setParameter('startDate', $startDate);
            $queryBuilder->setParameter('endDate', $endDate);
        }
        $queryBuilder = $queryBuilder
            ->andWhere('p.status = :status')
            ->setParameter('status', ContentStatusType::PUBLISHED)
            ->orderBy('p.publishedAt', 'DESC');
        $query = $queryBuilder->getQuery();
        $posts = $this->paginator->paginate($query, $page, 10);

        return $this->addCommonModel([
            'posts' => $posts
        ]);
    }

    /**
     * Returns a post list page by category.
     *
     * @param int $page The category page.
     * @param string $category The category slug or id.
     * @return array The model for the page.
     */
    public function listByCategory(int $page, string $category): array
    {
        $queryBuilder = $this->postRepository
            ->createQueryBuilder('p')
            ->join('p.categories', 'c')
            ->andWhere('p.status = :status')
            ->setParameter('status', ContentStatusType::PUBLISHED);

        if (is_numeric($category)) {
            $queryBuilder->andWhere('c.id = :category');
        } else {
            $queryBuilder->andWhere('c.slug = :category');
        }
        $queryBuilder
            ->setParameter('category', $category)
            ->orderBy('p.publishedAt', 'DESC');
        $query = $queryBuilder->getQuery();
        $posts = $this->paginator->paginate($query, $page, 10);

        return $this->addCommonModel([
            'posts' => $posts
        ]);
    }

    /**
     * Returns a post list page by tag.
     *
     * @param int $page The category page.
     * @param string $tag The tag slug or id.
     * @return array The model for the page.
     */
    public function listByTag(int $page, string $tag): array
    {
        $queryBuilder = $this->postRepository
            ->createQueryBuilder('p')
            ->join('p.tags', 't')
            ->andWhere('p.status = :status')
            ->setParameter('status', ContentStatusType::PUBLISHED);

        if (is_numeric($tag)) {
            $queryBuilder->andWhere('t.id = :tag');
        } else {
            $queryBuilder->andWhere('t.slug = :tag');
        }
        $queryBuilder
            ->setParameter('tag', $tag)
            ->orderBy('p.publishedAt', 'DESC');
        $query = $queryBuilder->getQuery();
        $posts = $this->paginator->paginate($query, $page, 10);

        return $this->addCommonModel([
            'posts' => $posts
        ]);
    }

    /**
     * Return the model of the post page.
     *
     * @param string $post The post slug or id.
     * @return array The model for the page.
     */
    public function post(string $post)
    {
        if (is_numeric($post)) {
            $post = $this->postRepository->findOneBy(['id' => intval($post)]);
        } else {
            $post = $this->postRepository->findOneBy(['slug' => $post]);
        }
        $commentForm = $this->formFactory->create(CommentType::class, new Comment(), [
            'action' => $this->router->generate('post_comment', ['postId' => $post->getId()])
        ]);

        return $this->addCommonModel([
            'post' => $post, 'commentForm' => $commentForm->createView()
        ]);
    }

    /**
     * Post a comment to a post.
     *
     * @param int $postId The post identifier.
     * @param Comment $comment The comment.
     */
    public function postComment(int $postId, Comment $comment): void
    {
        /** @var Post $post */
        $post = $this->postRepository->find($postId);
        if ($post === null) {
            throw new NotFoundHttpException("Post with id {$postId} not found.");
        }
        $comment->setPost($post);
        $this->entityManager->persist($comment);
        $this->entityManager->flush();
    }

    /**
     * Add the common model elements to the page.
     *
     * @param array $model The page model.
     * @return array The page model.
     */
    private function addCommonModel(array $model): array
    {
        $pages = $this->pageRepository->findBy(['status' => ContentStatusType::PUBLISHED], ['order' => 'ASC']);
        $archives = $this->postRepository->countByMonth();
        $categories = $this->categoryRepository->findBy([], ['name' => 'ASC']);

        return array_merge($model, [
            'pages' => $pages, 'archives' => $archives, 'categories' => $categories
        ]);
    }

    /**
     * Returns the start and dates that should be added to the query that restricts the posts to be fetched.
     *
     * @param int|null $year The post year. If null, fetch all posts.
     * @param int|null $month The post month. If null, fetch all posts in the year.
     * @param int|null $day The post day. If null, fetch all posts in the month.
     * @return array A two element array, with the start and end @see DateTime for the restriction.
     * @throws \Exception
     */
    private function getStartEnd(int $year = null, int $month = null, int $day = null): array
    {
        $startDate = new \DateTime();
        $startDate->setTime(0, 0);
        $endDate = new \DateTime();
        $endDate->setTime(0, 0);

        if ($year !== null && $month != null && $day != null) {
            $startDate = $startDate->setDate($year, $month, $day);
            $endDate = clone $startDate;
            $endDate->modify('+1 day');
        } elseif ($year !== null && $month != null) {
            $startDate = $startDate->setDate($year, $month, 1);
            $endDate = clone $startDate;
            $endDate->modify('+1 month');
        } elseif ($year !== null) {
            $startDate = $startDate->setDate($year, 1, 1);
            $endDate = clone $startDate;
            $endDate->modify('+1 year');
        } else {
            $startDate = null;
            $endDate = null;
        }

        return [$startDate, $endDate];
    }
}