<?php

/**
 * (c) Adrien PIERRARD
 */

namespace App\Controller;

use App\Form\ContactType;
use App\Manager\ContactManager;
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
     * @param Request        $request
     * @param ContactManager $contactManager
     *
     * @return Response
     *
     * @throws TransportExceptionInterface
     */
    public function contact(Request $request, ContactManager $contactManager): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contactManager->sendContactEmail($form->getData());
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
