<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Entity\Book;
use App\Form\ReservationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReservationController extends AbstractController
{
    #[Route('/book/{id}/reserve', name: 'book_reserve')]
    public function reserve(Book $book, Request $request, EntityManagerInterface $entityManager): Response
    {
        $reservation = new Reservation();
        $reservation->setUser($this->getUser());
        $reservation->setBook($book);

        $form = $this->createForm(ReservationFormType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($reservation);
            $entityManager->flush();

            $this->addFlash('success', 'Réservation effectuée avec succès.');

            return $this->redirectToRoute('user_reservations');
        }

        return $this->render('reservation/reserve.html.twig', [
            'book' => $book,
            'reservationForm' => $form->createView(),
        ]);
    }

    #[Route('/user/reservations', name: 'user_reservations')]
    public function userReservations(EntityManagerInterface $entityManager): Response
    {
        $reservations = $entityManager->getRepository(Reservation::class)
            ->findBy(['user' => $this->getUser()]);

        return $this->render('reservation/user_reservations.html.twig', [
            'reservations' => $reservations,
        ]);
    }
}
