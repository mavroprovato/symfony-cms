<?php

namespace App\Controller;

use App\Service\PostService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
    public function byCategory(string $post): Response
    {
        return $this->render('post.html.twig', $this->postService->post($post));
    }
}