<?php

namespace App\Service;

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

    /** @var PaginatorInterface The paginator service */
    private $paginator;

    /**
     * Create the controller.
     *
     * @param PostRepository $postRepository The post repository.
     * @param PaginatorInterface $paginator The paginator interface.
     */
    public function __construct(PostRepository $postRepository, PaginatorInterface $paginator)
    {
        $this->postRepository = $postRepository;
        $this->paginator = $paginator;
    }

    /**
     * Return a post list page.
     *
     * @param int $page The page number.
     * @return array The model for the page.
     */
    public function list(int $page = 1)
    {
        // Fetch contents by publication date
        $contentsQuery = $this->postRepository->createQueryBuilder('c')
            ->orderBy('c.publishedAt', 'DESC')
            ->getQuery();
        $contents = $this->paginator->paginate($contentsQuery, $page, 10);
        $archives = $this->postRepository->countByMonth();

        return [
            'contents' => $contents,
            'archives' => $archives
        ];
    }
}