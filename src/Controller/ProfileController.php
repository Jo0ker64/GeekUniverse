<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserProfileType;
use App\Repository\ReservationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function index(ReservationRepository $reservationRepository): Response
    {
        $user = $this->getUser();
        if (!$user instanceof User) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour accéder à cette page.');
        }

        $reservations = $reservationRepository->findBy(['user' => $user]);
        $borrowedBooks = $user->getBorrowedBooks();

        return $this->render('profile/index.html.twig', [
            'user' => $user,
            'reservations' => $reservations,
            'borrowedBooks' => $borrowedBooks,
        ]);
    }

    #[Route('/profile/edit', name: 'app_profile_edit')]
    public function edit(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = $this->getUser();
        if (!$user instanceof User) {
            throw new \LogicException('L\'utilisateur doit être une instance de App\Entity\User');
        }

        $form = $this->createForm(UserProfileType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($newPassword = $form->get('plainPassword')->getData()) {
                $user->setPassword($passwordHasher->hashPassword($user, $newPassword));
            }

            $entityManager->flush();

            $this->addFlash('success', 'Votre profil a été mis à jour avec succès.');

            return $this->redirectToRoute('app_profile');
        }

        return $this->render('profile/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/profile/reservations', name: 'app_profile_reservations')]
    public function reservations(ReservationRepository $reservationRepository): Response
    {
        $user = $this->getUser();
        if (!$user instanceof User) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour accéder à cette page.');
        }

        $reservations = $reservationRepository->findBy(['user' => $user]);

        return $this->render('profile/reservations.html.twig', [
            'reservations' => $reservations,
        ]);
    }

    #[Route('/profile/borrowed-books', name: 'app_profile_borrowed_books')]
    public function borrowedBooks(): Response
    {
        $user = $this->getUser();
        if (!$user instanceof User) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour accéder à cette page.');
        }

        $borrowedBooks = $user->getBorrowedBooks();

        return $this->render('profile/borrowed_books.html.twig', [
            'borrowedBooks' => $borrowedBooks,
        ]);
    }
}
