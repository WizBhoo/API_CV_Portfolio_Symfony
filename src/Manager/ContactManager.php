<?php

/**
 * (c) Adrien PIERRARD
 */

namespace App\Manager;

use App\Mailer\Sender;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mime\Address;

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
}
