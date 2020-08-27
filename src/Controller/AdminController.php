<?php

/**
 * (c) Adrien PIERRARD
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AdminController.
 */
class AdminController extends AbstractController
{
    /**
     * Show dashboard homepage.
     *
     * @return Response
     */
    public function dashboard(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }
}
