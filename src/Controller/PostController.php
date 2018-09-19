<?php

namespace App\Controller;

use App\Service\PostService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller for post list
 *
 * @package App\Controller
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
     * Display the index page.
     *
     * @Route("/", name="index", methods={"GET"})
     * @return string
     */
    public function index()
    {
        return $this->page('1');
    }

    /**
     * Display the index page.
     *
     * @Route("/page/{page}", name="index_page", methods={"GET"}, requirements={"page"="\d+"})
     * @param string $page The page number.
     * @return \Symfony\Component\HttpFoundation\Response The response.
     */
    public function page(string $page = '1')
    {
        return $this->render('index.html.twig', $this->postService->list(intval($page)));
    }
}