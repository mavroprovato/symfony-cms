<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller for administrating comments
 *
 * @package App\Controller
 * @Route(path = "/admin/comments")
 */
class AdminCommentsController extends Controller
{

    /**
     * Display the admin comments list.
     *
     * @Route(
     *     path="/",
     *     name="admin_comments",
     *     methods={"GET"},
     * )
     */
    public function index(): Response
    {
        return $this->render('admin/comments.html.twig');
    }
}