<?php

namespace App\Service;

use App\Repository\CommentRepository;

/**
 * The Comment service
 *
 * @package App\Service
 */
class CommentService
{

    /** @var CommentRepository The comment repository. */
    private $commentRepository;

    /**
     * CommentService constructor.
     *
     * @param CommentRepository $commentRepository
     */
    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    /**
     * Return the comments to include to the feed list.
     *
     * @return array The comments to include to the feed list.
     */
    public function getFeedItems()
    {
        return $this->commentRepository->findBy([], ['createdAt' => 'DESC'], 10);
    }
}