<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller for administrating users
 *
 * @package App\Controller
 * @Route(path = "/admin/users")
 */
class AdminUsersController extends Controller
{

    /**
     * Display the admin users list.
     *
     * @Route(
     *     path="/",
     *     name="admin_users",
     *     methods={"GET"},
     * )
     */
    public function index(): Response
    {
        return $this->render('admin/users.html.twig');
    }
}