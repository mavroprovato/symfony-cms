<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller for administration
 *
 * @package App\Controller
 * @Route(path = "/admin")
 */
class AdminController
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
    public function index(): Response
    {
        return new Response('OK');
    }
}