<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends Controller
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
        return $this->page('1');
    }

    /**
     * Display the index page.
     *
     * @Route("/page/{page}", name="index_page", methods={"GET"}, requirements={"page"="\d+"})
     * @param string $page The page number.
     * @return string
     */
    public function page(string $page = '1')
    {
        /** @var PostRepository $postRepository */
        $postRepository = $this->getDoctrine()->getRepository(Post::class);

        // Fetch contents by publication date
        $contentsQuery = $postRepository->createQueryBuilder('c')
            ->orderBy('c.publishedAt', 'DESC')
            ->getQuery();
        $contents = $this->paginator->paginate($contentsQuery, $page, 10);
        $archives = $postRepository->countByMonth();

        return $this->render('index.html.twig', [
            'contents' => $contents,
            'archives' => $archives
        ]);
    }
}