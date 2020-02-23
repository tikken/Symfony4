<?php
/**
 * Created by IntelliJ IDEA.
 * User: tikken
 * Date: 2/23/20
 * Time: 6:02 PM
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BlogController
 * @Route("/blog")
 */
class BlogController extends AbstractController
{
    private const POSTS = [
        [
            'id' => 1,
            'slug'=> 'first',
            'title' => 'first title'
        ],
        [
            'id' => 2,
            'slug'=> 'second',
            'title' => 'second title'
        ],
        [
            'id' => 3,
            'slug'=> 'third',
            'title' => 'third title'
        ],
        [
            'id' => 4,
            'slug'=> 'fourth',
            'title' => 'fourth title'
        ],
    ];
    /**
     * @Route("/", name="blog_list")
     */
    public function list()
    {
        return new JsonResponse(self::POSTS);
    }

    /**
     * @Route("/{id}", name="blog_by_id", requirements={"id"="\d+"})
     */
    public function post($id)
    {
        return new JsonResponse(
            self::POSTS[array_search($id, array_column(self::POSTS, 'id'))]
        );
    }

    /**
     * @Route("/{slug}", name="blog_by_slug")
     */
    public function postBySlug($slug)
    {
        return new JsonResponse(
            self::POSTS[array_search($slug, array_column(self::POSTS, 'slug'))]
        );
    }
}