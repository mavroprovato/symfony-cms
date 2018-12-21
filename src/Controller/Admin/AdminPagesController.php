<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller for administrating pages
 *
 * @package App\Controller
 * @Route(path = "/admin/pages")
 */
class AdminPagesController extends Controller
{

    /**
     * Display the admin pages list.
     *
     * @Route(
     *     path="/",
     *     name="admin_pages",
     *     methods={"GET"},
     * )
     */
    public function index(): Response
    {
        return $this->render('admin/pages.html.twig');
    }

}