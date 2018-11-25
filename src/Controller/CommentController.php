<?php

namespace App\Controller;

use App\Service\CommentService;
use Eko\FeedBundle\Feed\FeedManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller for post comments
 *
 * @package App\Controller
 */
class CommentController
{
    /** @var CommentService The comment service */
    private $commentService;

    /** @var FeedManager The feedManager */
    private $feedManager;

    /**
     * Create the controller.
     *
     * @param CommentService $commentService The comment service.
     * @param FeedManager $feedManager The feed manager.
     */
    public function __construct(CommentService $commentService, FeedManager $feedManager)
    {
        $this->commentService = $commentService;
        $this->feedManager = $feedManager;
    }

    /**
     * Display the comment feed.
     *
     * @Route(
     *     path="/comments/feed",
     *     name="comments_feed",
     *     methods={"GET"},
     * )
     */
    public function feed(): Response
    {
        $comments = $this->commentService->getFeedItems();
        $feed = $this->feedManager->get('comment');
        $feed->addFromArray($comments);

        return new Response($feed->render('atom'));
    }
}