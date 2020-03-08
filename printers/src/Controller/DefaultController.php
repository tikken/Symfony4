<?php
/**
 * Created by IntelliJ IDEA.
 * User: tikken
 * Date: 2/23/20
 * Time: 5:53 PM
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 *
 * @Route("/")
 */
class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default_index")
     */
    public function index()
    {
        return $this->render('base.html.twig');
    }
}