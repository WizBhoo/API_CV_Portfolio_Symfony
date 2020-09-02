<?php

namespace App\Controller;

use App\Form\ChangePasswordFormType;
use App\Form\ResetPasswordRequestFormType;
use App\Manager\ContactManager;
use App\Manager\UserManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use SymfonyCasts\Bundle\ResetPassword\Controller\ResetPasswordControllerTrait;
use SymfonyCasts\Bundle\ResetPassword\Exception\ResetPasswordExceptionInterface;
use SymfonyCasts\Bundle\ResetPassword\ResetPasswordHelperInterface;

/**
 * Class ResetPasswordController.
 */
class ResetPasswordController extends AbstractController
{
    use ResetPasswordControllerTrait;

    /**
     * A ResetPasswordHelperInterface Injection.
     *
     * @var ResetPasswordHelperInterface
     */
    private $resetPasswordHelper;

    /**
     * A UserManager Instance.
     *
     * @var UserManager
     */
    private $userManager;

    /**
     * A ContactManager Instance.
     *
     * @var ContactManager
     */
    private $contactManager;

    /**
     * ResetPasswordController constructor.
     *
     * @param ResetPasswordHelperInterface $resetPasswordHelper
     * @param UserManager                  $userManager
     * @param ContactManager               $contactManager
     */
    public function __construct(ResetPasswordHelperInterface $resetPasswordHelper, UserManager $userManager, ContactManager $contactManager)
    {
        $this->resetPasswordHelper = $resetPasswordHelper;
        $this->userManager = $userManager;
        $this->contactManager = $contactManager;
    }

    /**
     * Display & process form to request a password reset.
     *
     * @param Request $request
     *
     * @return Response
     *
     * @throws TransportExceptionInterface
     */
    public function request(Request $request): Response
    {
        $form = $this->createForm(ResetPasswordRequestFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->processSendingPasswordResetEmail(
                $form->get('email')->getData()
            );
        }

        return $this->render(
            'reset_password/request.html.twig',
            ['requestForm' => $form->createView()]
        );
    }

    /**
     * Confirmation page after a user has requested a password reset.
     *
     * @return Response
     */
    public function checkEmail(): Response
    {
        if (!$this->canCheckEmail()) {
            return $this->redirectToRoute('app_forgot_password_request');
        }

        return $this->render(
            'reset_password/check_email.html.twig',
            ['tokenLifetime' => $this->resetPasswordHelper->getTokenLifetime()]
        );
    }

    /**
     * Validates and process the reset URL that the user clicked in their email.
     *
     * @param Request     $request
     * @param string|null $token
     *
     * @return Response
     *
     * @throws ORMException|OptimisticLockException
     */
    public function reset(Request $request, ?string $token): Response
    {
        if ($token) {
            $this->storeTokenInSession($token);

            return $this->redirectToRoute('app_reset_password');
        }

        $token = $this->getTokenFromSession();
        if (null === $token) {
            throw $this->createNotFoundException(
                'No reset password token found.'
            );
        }

        try {
            $user = $this->resetPasswordHelper->validateTokenAndFetchUser($token);
        } catch (ResetPasswordExceptionInterface $e) {
            $this->addFlash('reset_password_error', sprintf(
                'There was a problem validating your reset request - %s',
                $e->getReason()
            ));

            return $this->redirectToRoute('app_forgot_password_request');
        }

        $form = $this->createForm(ChangePasswordFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->resetPasswordHelper->removeResetRequest($token);
            $this->userManager->updateUserPassword(
                $user,
                $form->get('plainPassword')->getData()
            );
            $this->cleanSessionAfterReset();

            return $this->redirectToRoute('app_login');
        }

        return $this->render(
            'reset_password/reset.html.twig',
            ['resetForm' => $form->createView()]
        );
    }

    /**
     * @param string $emailFormData
     *
     * @return RedirectResponse
     *
     * @throws TransportExceptionInterface
     */
    private function processSendingPasswordResetEmail(string $emailFormData): RedirectResponse
    {
        $user = $this->userManager->findUserByEmail($emailFormData);

        $this->setCanCheckEmailInSession();

        if (!$user) {
            return $this->redirectToRoute('app_check_email');
        }

        try {
            $resetToken = $this->resetPasswordHelper->generateResetToken($user);
        } catch (ResetPasswordExceptionInterface $e) {
            return $this->redirectToRoute('app_check_email');
        }

        $this->contactManager->sendPasswordResetEmail(
            $user,
            $resetToken,
            $this->resetPasswordHelper->getTokenLifetime()
        );

        return $this->redirectToRoute('app_check_email');
    }
}
