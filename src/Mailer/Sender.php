<?php

/**
 * (c) Adrien PIERRARD
 */

namespace App\Mailer;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;

/**
 * Class Sender.
 */
class Sender
{
    /**
     * A MailerInterface Injection.
     *
     * @var MailerInterface
     */
    private $mailer;

    /**
     * Sender constructor.
     *
     * @param MailerInterface $mailer
     */
    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Send Email.
     *
     * @param TemplatedEmail $email
     *
     * @return void
     *
     * @throws TransportExceptionInterface
     */
    public function sendEmail(TemplatedEmail $email): void
    {
        $this->mailer->send($email);
    }
}
