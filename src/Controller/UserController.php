<?php

/**
 * (c) Adrien PIERRARD
 */

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class UserController.
 */
class UserController extends AbstractController
{
    /**
     * Register a new User.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function register(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        return $this->render(
            'security/register.html.twig',
            ['form' => $form->createView()]
        );
    }
}
