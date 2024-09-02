<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Reservation;
use App\Repository\BookRepository;
use App\Enum\BookStatus;
use Doctrine\ORM\EntityManagerInterface;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/book')]
class BookController extends AbstractController
{
    #[Route('', name: 'app_book_index', methods: ['GET'])]
    public function index(Request $request, BookRepository $repository): Response
    {
        $books = Pagerfanta::createForCurrentPageWithMaxPerPage(
            new QueryAdapter($repository->createQueryBuilder('b')),
            $request->query->get('page', 1),
            20
        );

        return $this->render('book/index.html.twig', [
            'books' => $books,
        ]);
    }

    #[Route('/{id}', name: 'app_book_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(?Book $book): Response
    {
        if (!$book) {
            throw $this->createNotFoundException('Le livre demandé n\'existe pas.');
        }

        return $this->render('book/show.html.twig', [
            'book' => $book,
        ]);
    }

    #[Route('/{id}/reserve', name: 'app_book_reserve', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function reserve(Book $book, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        if ($book->getStatus() !== BookStatus::Available) {
            $this->addFlash('error', 'Ce livre n\'est pas disponible pour la réservation.');
            return $this->redirectToRoute('app_book_show', ['id' => $book->getId()]);
        }

        $reservation = new Reservation();
        $reservation->setBook($book);
        $reservation->setUser($this->getUser());
        $reservation->setReservationDate(new \DateTime());

        $entityManager->persist($reservation);

        // Mettez à jour le statut du livre
        $book->setStatus(BookStatus::Borrowed);
        
        $entityManager->flush();

        $this->addFlash('success', 'Le livre a été réservé avec succès.');

        return $this->redirectToRoute('app_book_show', ['id' => $book->getId()]);
    }
}
