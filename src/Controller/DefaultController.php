<?php

namespace App\Controller;

use Doctrine\ORM\EntityManager;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{

    /** @var PaginatorInterface The paginator service */
    private $paginator;

    /**
     * Create the controller.
     *
     * @param PaginatorInterface $paginator The paginator interface.
     */
    public function __construct(PaginatorInterface $paginator)
    {
        $this->paginator = $paginator;
    }

    /**
     * Display the index page.
     *
     * @Route("/")
     * @return string
     */
    public function index()
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->getDoctrine()->getManager();
        $query = $entityManager->createQuery('
            SELECT c 
            FROM App\Entity\Content c 
            ORDER BY c.publishedAt DESC
        ');
        $contents = $this->paginator->paginate($query, 1, 10);

        return $this->render('index.html.twig', ['contents' => $contents]);
    }
}