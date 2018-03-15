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
     * @Route("/", name="index", methods={"GET"})
     * @return string
     */
    public function index()
    {
        return $this->indexPage('1');
    }

    /**
     * Display the index page.
     *
     * @Route("/page/{page}", name="index_page", methods={"GET"}, requirements={"page"="\d+"})
     * @param string $page The page number.
     * @return string
     */
    public function indexPage(string $page)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->getDoctrine()->getManager();
        $query = $entityManager->createQuery('
            SELECT c 
            FROM App\Entity\Content c 
            ORDER BY c.publishedAt DESC
        ');
        $contents = $this->paginator->paginate($query, $page, 10);

        return $this->render('index.html.twig', ['contents' => $contents]);
    }
}