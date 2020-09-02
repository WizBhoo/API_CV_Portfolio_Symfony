<?php

/**
 * (c) Adrien PIERRARD
 */

namespace App\Manager;

use App\Entity\User;
use App\Mailer\Sender;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mime\Address;
use SymfonyCasts\Bundle\ResetPassword\Model\ResetPasswordToken;

/**
 * Class ContactManager.
 */
class ContactManager
{
    /**
     * A Sender Instance.
     *
     * @var Sender
     */
    private $sender;

    /**
     * ContactManager constructor.
     *
     * @param Sender $sender
     */
    public function __construct(Sender $sender)
    {
        $this->sender = $sender;
    }

    /**
     * Build and send a contact email.
     *
     * @param array $contact
     *
     * @return void
     *
     * @throws TransportExceptionInterface
     */
    public function sendContactEmail(array $contact): void
    {
        $email = (new TemplatedEmail())
            ->from(new Address('wizbhoo.dev@gmail.com', 'APi - Contact Form'))
            ->to(new Address('apierrard.contact@gmail.com', 'APi - CV & Portfolio'))
            ->replyTo($contact['email'])
            ->subject($contact['subject'])
            ->htmlTemplate('emails/contactHTML.html.twig')
            ->context(['contact' => $contact])
        ;

        $this->sender->sendEmail($email);
    }

    /**
     * Build and send a password reset email.
     *
     * @param User               $user
     * @param ResetPasswordToken $resetToken
     * @param int                $tokenLifetime
     *
     * @return void
     *
     * @throws TransportExceptionInterface
     */
    public function sendPasswordResetEmail(User $user, ResetPasswordToken $resetToken, int $tokenLifetime): void
    {
        $email = (new TemplatedEmail())
            ->from(new Address('wizbhoo.dev@gmail.com', 'APi - Reset Password'))
            ->to($user->getEmail())
            ->subject('Your password reset request')
            ->htmlTemplate('emails/reset_passwordHTML.html.twig')
            ->context([
                'resetToken' => $resetToken,
                'tokenLifetime' => $tokenLifetime,
            ])
        ;

        $this->sender->sendEmail($email);
    }
}
