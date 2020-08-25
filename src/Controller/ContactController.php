<?php

/**
 * (c) Adrien PIERRARD
 */

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Mailer\MailerMessage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

/**
 * Class ContactController.
 */
class ContactController extends AbstractController
{
    /**
     * Show contact page with contact form.
     *
     * @param Request       $request
     * @param MailerMessage $mailer
     *
     * @return Response
     *
     * @throws TransportExceptionInterface
     */
    public function contact(Request $request, MailerMessage $mailer): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mailer->sendContactEmail($contact);
            $this->addFlash(
                'success',
                'Your message has been sent !'
            );

            return $this->redirectToRoute('app_contact');
        }

        return $this->render(
            'site/contact.html.twig',
            ['form' => $form->createView()]
        );
    }
}
