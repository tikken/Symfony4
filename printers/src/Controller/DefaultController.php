<?php
/**
 * Created by IntelliJ IDEA.
 * User: tikken
 * Date: 2/23/20
 * Time: 5:53 PM
 */

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 *
 * @Route("/")
 */
class DefaultController
{
    /**
     * @Route("/", name="default_index")
     */
    public function index()
    {
        return new JsonResponse([
            'action' => 'index',
            'time' => time()
        ]);
    }
}