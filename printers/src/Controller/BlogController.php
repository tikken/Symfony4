<?php
/**
 * Created by IntelliJ IDEA.
 * User: tikken
 * Date: 2/23/20
 * Time: 6:02 PM
 */

namespace App\Controller;

use App\Entity\BlogPost;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("/", name="blog_list", requirements={"page"="\d+"})
     */
    public function list($page = 1, Request $request)
    {
        $limit = $request->get('limit', 10);

        return $this->json([
            'page' => $page,
            'limit' => $limit,
            'data' => array_map(function($item) {
                return $this->generateUrl('blog_by_id', ['id' => $item['id']]);
            },self::POSTS)
        ]);
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
     * @Route("/{slug}", name="blog_by_slug", requirements={"slug"="\d+"})
     */
    public function postBySlug($slug)
    {
        return new JsonResponse(
            self::POSTS[array_search($slug, array_column(self::POSTS, 'slug'))]
        );
    }

    /**
     * @Route("/add", name="blog_add", methods={"POST"})
     */
    public function add(Request $request)
    {
        $serializer = $this->get('serializer');

        $blogPost = $serializer->deserialize($request->getContent(), BlogPost::class, 'json');

        $em = $this->getDoctrine()->getManager();
        $em->persist($blogPost);
        $em->flush();

        return $this->json($blogPost);
    }
}