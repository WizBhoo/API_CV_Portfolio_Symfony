<?php

/**
 * (c) Adrien PIERRARD
 */

namespace App\Security;

use App\Manager\ContactManager;
use App\Manager\UserManager;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use SymfonyCasts\Bundle\ResetPassword\Exception\ResetPasswordExceptionInterface;
use SymfonyCasts\Bundle\ResetPassword\ResetPasswordHelperInterface;

/**
 * Class ResetPasswordRequester.
 */
class ResetPasswordRequester
{
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
     * ResetPasswordRequester constructor.
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
     * Process the request to send a reset password email.
     *
     * @param string $emailFormData
     *
     * @throws TransportExceptionInterface
     */
    public function processPasswordRequest(string $emailFormData): void
    {
        $user = $this->userManager->findUserByEmail($emailFormData);

        if (!$user) {
            return;
        }

        try {
            $resetToken = $this->resetPasswordHelper->generateResetToken($user);
            $this->contactManager->sendPasswordResetEmail(
                $user,
                $resetToken,
                $this->resetPasswordHelper->getTokenLifetime()
            );
        } catch (ResetPasswordExceptionInterface $e) {
        }
    }
}
