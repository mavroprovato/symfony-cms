<?php

namespace App\Controller;

use App\Entity\Content;
use App\Repository\ContentRepository;
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
     * @Route("/", methods={"GET"})
     * @return string
     */
    public function index()
    {
        return $this->indexPage('1');
    }

    /**
     * Display the index page.
     *
     * @Route("/page/{page}", methods={"GET"}, requirements={"page"="\d+"})
     * @param string $page The page number.
     * @return string
     */
    public function indexPage(string $page)
    {
        /** @var ContentRepository $contentRepository */
        $contentRepository = $this->getDoctrine()->getRepository(Content::class);

        // Fetch contents by publication date
        $contentsQuery = $contentRepository->createQueryBuilder('c')
            ->orderBy('c.publishedAt', 'DESC')
            ->getQuery();
        $contents = $this->paginator->paginate($contentsQuery, $page, 10);

        // Fetch contents per publication month
        $archiveQuery = $contentRepository->createQueryBuilder('c')
            ->select('YEAR(c.publishedAt) AS year, MONTH(c.publishedAt) AS month, COUNT(c)')
            ->groupBy('year, month')
            ->getQuery();
        $archives = $archiveQuery->getResult();

        return $this->render('index.html.twig', [
            'contents' => $contents,
            'archives' => $archives
        ]);
    }
}