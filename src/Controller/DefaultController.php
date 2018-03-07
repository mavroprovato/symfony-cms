<?php

namespace App\Controller;

use App\Entity\Content;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{

    /**
     * The default controller.
     *
     * @Route("/")
     * @return string
     */
    public function index()
    {
        $repository = $this->getDoctrine()->getRepository(Content::class);
        $contents = $repository->findBy([], ['publishedAt' => 'DESC'], 10);

        return $this->render('index.html.twig', ['contents' => $contents]);
    }
}