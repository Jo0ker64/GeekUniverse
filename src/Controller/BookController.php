<?php

namespace App\Controller;

use App\Entity\Book;
use DateTimeImmutable;
use App\Enum\BookStatus;
use Pagerfanta\Pagerfanta;
use App\Entity\Reservation;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/book')]
class BookController extends AbstractController
{
    #[Route('', name: 'app_book_index', methods: ['GET'])]
    public function index(Request $request, BookRepository $repository): Response
    {
        $page = $request->query->getInt('page', 1);
        $searchTerm = $request->query->get('q', '');
    
        if (!empty($searchTerm)) {
            $queryBuilder = $repository->createSearchQueryBuilder($searchTerm);
        } else {
            $queryBuilder = $repository->createQueryBuilder('b');
        }
    
        $books = Pagerfanta::createForCurrentPageWithMaxPerPage(
            new QueryAdapter($queryBuilder),
            $page,
            20
        );
    
        return $this->render('book/index.html.twig', [
            'books' => $books,
            'searchTerm' => $searchTerm,
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
        $reservation->setReservationDate(new DateTimeImmutable());

        $entityManager->persist($reservation);

        // Mettez à jour le statut du livre
        $book->setStatus(BookStatus::Borrowed);
        
        $entityManager->flush();

        $this->addFlash('success', 'Le livre a été réservé avec succès.');

        return $this->redirectToRoute('app_book_show', ['id' => $book->getId()]);
    }
}
