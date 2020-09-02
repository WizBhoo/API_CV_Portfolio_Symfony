<?php

/**
 * (c) Adrien PIERRARD
 */

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Manager\UserManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class UserController.
 */
class UserController extends AbstractController
{
    /**
     * A UserManager Instance.
     *
     * @var UserManager
     */
    private $userManager;

    /**
     * UserController constructor.
     *
     * @param UserManager $userManager
     */
    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
    }

    /**
     * Show the Users list.
     *
     * @return Response
     */
    public function usersList(): Response
    {
        return $this->render(
            'admin/users.html.twig',
            [
                'users' => $this->userManager->findAllUsers(),
            ]
        );
    }

    /**
     * Register a new User.
     *
     * @param Request $request
     *
     * @return Response
     *
     * @throws ORMException|OptimisticLockException
     */
    public function register(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->userManager->createUser($user);

            $this->addFlash(
                'success',
                "New User Account created !"
            );

            return $this->redirectToRoute('app_admin_users');
        }

        return $this->render(
            'admin/register.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * Switch User role from Admin to User and vice versa.
     *
     * @param User $user
     *
     * @return Response
     *
     * @throws ORMException|OptimisticLockException
     */
    public function switch(User $user): Response
    {
        $this->userManager->switchRole($user);

        return $this->redirectToRoute('app_admin_users');
    }

    /**
     * Delete a user.
     *
     * @param Request $request
     * @param User    $user
     *
     * @return Response
     *
     * @throws ORMException|OptimisticLockException
     */
    public function delete(Request $request, User $user): Response
    {
        if (!$this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $this->addFlash(
                'error',
                'Error please try again !'
            );

            return $this->redirectToRoute('app_admin_users');
        }

        $this->userManager->deleteUser($user);
        $this->addFlash(
            'success',
            "User has been well deleted"
        );

        return $this->redirectToRoute('app_admin_users');
    }
}
