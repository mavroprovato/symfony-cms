<?php

namespace App\Controller;

use App\Service\PostService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Controller for post list
 *
 * @package App\Controller
 */
class PostListController extends Controller
{
    /** @var PostService The post service */
    private $postService;

    /**
     * Create the controller.
     *
     * @param PostService $postService The post service.
     */
    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    /**
     * Display the post list page.
     *
     * @Route("/", name="posts", methods={"GET"})
     * @return string
     */
    public function list()
    {
        return $this->dayPage();
    }

    /**
     * Display the post list page.
     *
     * @Route(
     *     path="/page/{page}",
     *     name="posts_page",
     *     methods={"GET"},
     *     requirements={"page"="\d+"},
     *     defaults={"page"="1"}
     * )
     * @return string
     */
    public function page($page)
    {
        return $this->dayPage($page);
    }

    /**
     * Display the day post list.
     *
     * @Route(
     *     path="/{year}/{month}/{day}",
     *     name="posts_date",
     *     methods={"GET"},
     *     requirements={"year"="\d+", "month"="\d+", "day"="\d+"},
     *     defaults={"year"=null, "month"=null, "day"=null}
     * )
     * @return string
     */
    public function listDay($year = null, $month = null, $day = null)
    {
        return $this->dayPage('1', $year, $month, $day);
    }

    /**
     * Display the year page.
     *
     * @Route(
     *     "/{year}/page/{page}",
     *     name="posts_year_page",
     *     methods={"GET"},
     *     requirements={"page"="\d+", "year"="\d+"},
     *     defaults={"page"="1", "year"=null}
     * )
     * @param string $page The page number.
     * @return \Symfony\Component\HttpFoundation\Response The response.
     */
    public function yearPage(string $page = '1', $year = null)
    {
        return $this->dayPage($page, $year);
    }

    /**
     * Display the month page.
     *
     * @Route(
     *     "/{year}/{month}/page/{page}",
     *     name="posts_month_page",
     *     methods={"GET"},
     *     requirements={"page"="\d+", "year"="\d+", "month"="\d+"},
     *     defaults={"page"="1", "year"=null}
     * )
     * @param string $page The page number.
     * @return \Symfony\Component\HttpFoundation\Response The response.
     */
    public function monthPage(string $page = '1', $year = null, $month = null)
    {
        return $this->dayPage($page, $year, $month);
    }

    /**
     * Display the day page.
     *
     * @Route(
     *     "/{year}/{month}/{day}/page/{page}",
     *     name="posts_day_page",
     *     methods={"GET"},
     *     requirements={"page"="\d+", "year"="\d+", "month"="\d+", "day"="\d+"},
     *     defaults={"page"="1", "year"=null, "month"=null, "day"=null}
     * )
     * @param string $page The page number.
     * @return \Symfony\Component\HttpFoundation\Response The response.
     */
    public function dayPage(string $page = '1', $year = null, $month = null, $day = null)
    {
        return $this->render('posts.html.twig', $this->postService->list(
            intval($page),
            $year === null ? null : intval($year),
            $month === null ? null : intval($month),
            $day === null ? null : intval($day)
        ));
    }
}