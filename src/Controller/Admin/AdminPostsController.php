<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller for administrating posts
 *
 * @package App\Controller
 * @Route(path = "/admin/posts")
 */
class AdminPostsController extends Controller
{

    /**
     * Display the admin post list.
     *
     * @Route(
     *     path="/",
     *     name="admin_posts",
     *     methods={"GET"},
     * )
     */
    public function index(): Response
    {
        return $this->render('admin/posts.html.twig');
    }
}