<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Service\EmailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class RegistrationController extends AbstractController
{
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/admin/user/new', name: 'app_register')]
    public function register(
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher, 
        EntityManagerInterface $entityManager
    ): Response {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('app_main');
        }
        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form,
        ]);
    }

    #[Route('/register', name: 'register')]
    public function registerNewUser(
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher, 
        EntityManagerInterface $entityManager,
        EmailService $emailService,
        TokenGeneratorInterface $tokenGenerator
    ): Response {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            // Générer un token de confirmation
            $confirmationToken = $tokenGenerator->generateToken();
            $user->setConfirmationToken($confirmationToken);
            $user->setIsVerified(false);

            $entityManager->persist($user);
            $entityManager->flush();

            // Envoyer l'email de confirmation
            $emailContent = $this->renderView('emails/registration_confirmation.html.twig', [
                'user' => $user,
                'token' => $confirmationToken
            ]);

            $emailService->sendEmail(
                $user->getEmail(),
                'Confirmez votre inscription',
                $emailContent
            );

            $this->addFlash('success', 'Un email de confirmation vous a été envoyé. Veuillez vérifier votre boîte de réception.');
            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form,
        ]);
    }

    #[Route('/verify-email/{token}', name: 'app_verify_email')]
    public function verifyEmail(string $token, EntityManagerInterface $entityManager): Response
    {
        $user = $entityManager->getRepository(User::class)->findOneBy(['confirmationToken' => $token]);

        if (!$user) {
            throw $this->createNotFoundException('Utilisateur non trouvé');
        }

        $user->setIsVerified(true);
        $user->setConfirmationToken(null);
        $entityManager->flush();

        $this->addFlash('success', 'Votre compte a été vérifié. Vous pouvez maintenant vous connecter.');

        return $this->redirectToRoute('app_login');
    }
}
