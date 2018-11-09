<?php

namespace App\Service;

use App\Repository\PageRepository;
use App\Repository\PostRepository;
use Knp\Component\Pager\PaginatorInterface;

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

    /** @var PaginatorInterface The paginator service */
    private $paginator;

    /**
     * Create the post service.
     *
     * @param PostRepository $postRepository The post repository.
     * @param PageRepository $pageRepository The page repository.
     * @param PaginatorInterface $paginator The paginator interface.
     */
    public function __construct(PostRepository $postRepository, PageRepository $pageRepository,
                                PaginatorInterface $paginator)
    {
        $this->postRepository = $postRepository;
        $this->pageRepository = $pageRepository;
        $this->paginator = $paginator;
    }

    /**
     * Return a post list page.
     *
     * @param int $page The page number.
     * @param int|null $year The year of the posts to include. If null, fetch all posts.
     * @param int|null $month The month of the posts to include. If null, fetch all posts in the year.
     * @param int|null $day The day of the posts to include. If null, fetch all posts in the month.
     * @return array The model for the page.
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
        $queryBuilder = $queryBuilder->orderBy('p.publishedAt', 'DESC');
        $query = $queryBuilder->getQuery();
        $contents = $this->paginator->paginate($query, $page, 10);
        $archives = $this->postRepository->countByMonth();
        $pages = $this->pageRepository->findBy([], ['order' => 'ASC']);

        return [
            'contents' => $contents,
            'pages' => $pages,
            'archives' => $archives
        ];
    }

    /**
     * Returs the start and dates that should be added to the query that restricts the posts to be fetched.
     *
     * @param int|null $year The post year. If null, fetch all posts.
     * @param int|null $month The post month. If null, fetch all posts in the year.
     * @param int|null $day The post day. If null, fetch all posts in the month.
     * @return array A two element array, with the start and end @see DateTime for the restriction.
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