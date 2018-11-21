<?php

namespace App\Controller;

use App\Form\CommentType;
use App\Service\PostService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * The post controller.
 */
class PostController extends Controller
{
    /** @var PostService The post service */
    private $postService;

    /**
     * Create the controller.
     *
     * @param PostService $postService The post service.
     */
    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    /**
     * Display the post.
     *
     * @Route(
     *     path="/post/{post}",
     *     name="post",
     *     methods={"GET"},
     * )
     * @param string $post The post id or slug.
     * @return Response The response.
     */
    public function post(string $post): Response
    {
        return $this->render('post.html.twig', $this->postService->post($post));
    }

    /**
     * Post a comment.
     *
     * @Route(
     *     path="/post/{postId}/comment",
     *     name="post_comment",
     *     methods={"POST"},
     * )
     * @param string $postId The post identifier.
     * @param Request $request The request.
     * @return Response The response.
     */
    public function postComment(string $postId, Request $request)
    {
        $form = $this->createForm(CommentType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->postService->postComment($postId, $form->getData());

            return $this->render('post.html.twig', $this->postService->post($postId));
        }

        return $this->render('post.html.twig', $this->postService->post($postId));
    }
}