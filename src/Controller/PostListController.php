<?php

namespace App\Controller;

use App\Service\PostService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
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
     * @Route(
     *     path="/",
     *     methods={"GET"},
     *     name="posts"
     * )
     * @Route(
     *     path="/page/{page}",
     *     name="posts_page",
     *     methods={"GET"},
     *     requirements={"page"="\d+"}
     * )
     * @Route(
     *     "/{year}",
     *     name="posts_year",
     *     methods={"GET"},
     *     requirements={"year"="\d+"}
     * )
     * @Route(
     *     "/{year}/page/{page}",
     *     name="posts_year_page",
     *     methods={"GET"},
     *     requirements={"page"="\d+", "year"="\d+"}
     * )
     * @Route(
     *     "/{year}/{month}",
     *     name="posts_month",
     *     methods={"GET"},
     *     requirements={"year"="\d+", "month"="\d+"}
     * )
     * @Route(
     *     "/{year}/{month}/page/{page}",
     *     name="posts_month_page",
     *     methods={"GET"},
     *     requirements={"page"="\d+", "year"="\d+", "month"="\d+"}
     * )
     * @Route(
     *     "/{year}/{month}/{day}",
     *     name="posts_day",
     *     methods={"GET"},
     *     requirements={"year"="\d+", "month"="\d+", "day"="\d+"}
     * )
     * @Route(
     *     "/{year}/{month}/{day}/page/{page}",
     *     name="posts_day_page",
     *     methods={"GET"},
     *     requirements={"page"="\d+", "year"="\d+", "month"="\d+", "day"="\d+"}
     * )
     * @param string $page The page number.
     * @param string|null $year The page year. If null, all the posts are included.
     * @param string|null $month The page month. If null, all the posts in the year are included.
     * @param string|null $day The post day. If null, all the posts in the day are included.
     * @return Response The HTTP response.
     */
    public function byDate(string $page = '1', string $year = null, string $month = null, string $day = null): Response
    {
        return $this->render('posts.html.twig', $this->postService->list(
            intval($page),
            $year === null ? null : intval($year),
            $month === null ? null : intval($month),
            $day === null ? null : intval($day)
        ));
    }

    /**
     * Display the post list by category.
     *
     * @Route(
     *     "/category/{category}",
     *     name="posts_category",
     *     defaults={"page"="1"}
     * )
     * @Route(
     *     "/category/{category}/page/{page}",
     *     name="posts_category_page",
     *     requirements={"page"="\d+"}
     * )
     * @Method("GET")
     * @param string $page The page number.
     * @param string $category The category id or slug.
     * @return Response The response.
     */
    public function byCategory(string $page, string $category): Response
    {
        return $this->render('posts.html.twig', $this->postService->listByCategory(
            intval($page), $category
        ));
    }

    /**
     * Display the post list by tag.
     *
     * @Route(
     *     "/tag/{tag}",
     *     name="posts_tag",
     *     defaults={"page"="1"}
     * )
     * @Route(
     *     "/posts/{post}/page/{page}",
     *     name="posts_tag_page",
     *     requirements={"page"="\d+"}
     * )
     * @Method("GET")
     * @param string $page The page number.
     * @param string $tag The tag id or slug.
     * @return Response The response.
     */
    public function byTag(string $page, string $tag): Response
    {
        return $this->render('posts.html.twig', $this->postService->listByTag(
            intval($page), $tag
        ));
    }
}