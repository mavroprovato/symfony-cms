<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller for administration
 *
 * @package App\Controller
 * @Route(path = "/admin")
 */
class AdminController extends Controller
{
    /**
     * Display the admin dashboard.
     *
     * @Route(
     *     path="/",
     *     name="admin_index",
     *     methods={"GET"},
     * )
     */
    public function dashboard(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }
}