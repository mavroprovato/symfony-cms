<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller for administrating settings
 *
 * @package App\Controller
 * @Route(path = "/admin/settings")
 */
class AdminSettingsController extends Controller
{

    /**
     * Display the admin settings list.
     *
     * @Route(
     *     path="/",
     *     name="admin_settings",
     *     methods={"GET"},
     * )
     */
    public function index(): Response
    {
        return $this->render('admin/settings.html.twig');
    }
}