<?php

/**
 * (c) Adrien PIERRARD
 */

namespace App\Tests\Functional\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class ContactControllerTest.
 */
class ContactControllerTest extends WebTestCase
{
    /**
     * Contact page test.
     *
     * @return void
     */
    public function testSendContactEmail(): void
    {
        $client = static::createClient();
        $crawler = $client->request(
            'GET',
            '/contact'
        );
        $this->assertResponseIsSuccessful();

        $form = $crawler->selectButton('Envoyer')->form();
        $form['contact[firstname]']->setValue('Aka');
        $form['contact[lastname]']->setValue('Lee');
        $form['contact[email]']->setValue('aka.lee@example.com');
        $form['contact[subject]']->setValue('test contact message');
        $form['contact[message]']
            ->setValue('this message is sent to test the form')
        ;
        $client->submit($form);

        $this->assertResponseRedirects('/contact');

        $this->assertEmailCount(1);
        $email = $this->getMailerMessage(0);
        $this->assertEmailHeaderSame(
            $email,
            'To',
            'APi - CV & Portfolio <apierrard.contact@gmail.com>'
        );
        $this->assertEmailHtmlBodyContains(
            $email,
            'message',
            'this message is sent to test the form'
        );
    }
}
