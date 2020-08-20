<?php

/**
 * (c) Adrien PIERRARD
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class HomeController.
 */
class HomeController extends AbstractController
{
    /**
     * Show homepage.
     *
     * @return Response
     */
    public function home(): Response
    {
        return $this->render('site/home.html.twig');
    }
}
