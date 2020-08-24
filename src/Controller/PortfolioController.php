<?php

/**
 * (c) Adrien PIERRARD
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class PortfolioController.
 */
class PortfolioController extends AbstractController
{
    /**
     * Show portfolio.
     *
     * @return Response
     */
    public function portfolio(): Response
    {
        return $this->render('site/portfolio.html.twig');
    }

    /**
     * Show project details.
     *
     * @param string $project
     *
     * @return Response
     */
    public function show(string $project): Response
    {
        $view = 'site/works/'.$project.'.html.twig';
        if (!$this->get('twig')->getLoader()->exists($view)) {
            throw $this->createNotFoundException('The project does not exist');
        }

        return $this->render($view);
    }
}
