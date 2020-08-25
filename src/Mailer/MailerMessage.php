<?php

/**
 * (c) Adrien PIERRARD
 */

namespace App\Mailer;

use App\Entity\Contact;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

/**
 * Class MailerMessage.
 */
class MailerMessage
{
    /**
     * A MailerInterface Injection.
     *
     * @var MailerInterface
     */
    private $mailer;

    /**
     * MailerMessage constructor.
     *
     * @param MailerInterface $mailer
     */
    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Send email from contact form
     *
     * @param Contact $contact
     *
     * @return void
     *
     * @throws TransportExceptionInterface
     */
    public function sendContactEmail(Contact $contact): void
    {
        $email = (new TemplatedEmail())
            ->from(new Address('wizbhoo.dev@gmail.com', 'APi - Contact Form'))
            ->to(new Address('apierrard.contact@gmail.com', 'APi - CV & Portfolio'))
            ->replyTo($contact->getEmail())
            ->subject($contact->getSubject())
            ->htmlTemplate('emails/contactHTML.html.twig')
            ->context(
                [
                    'contact' => $contact,
                ]
            )
        ;

        $this->mailer->send($email);
    }
}
