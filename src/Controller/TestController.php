<?php

namespace App\Controller;

use Exception;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TestController extends AbstractController
{
    #[Route('/test-email', name: 'test_email')]
    public function testEmail(MailerInterface $mailer): Response
    {
        $emailSent = true;

        try {
            $email = (new Email())
                ->from('hello@example.com')
                ->to('you@example.com')
                ->subject('Test email')
                ->text('This is a test email sent from Symfony Mailer')
                ->html('<p>This is a test email sent from Symfony Mailer</p>');

            $mailer->send($email);
        } catch (Exception $e) {
            $emailSent = false;
        }

        return $this->render('test/test_email.html.twig', [
            'emailSent' => $emailSent,
        ]);
    }
}
