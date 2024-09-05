<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    public function createSearchQueryBuilder(string $searchTerm): QueryBuilder
    {
        return $this->createQueryBuilder('b')
            ->leftJoin('b.authors', 'a')
            ->where('b.title LIKE :term')
            ->orWhere('b.isbn LIKE :term')
            ->orWhere('a.name LIKE :term')
            ->setParameter('term', '%' . $searchTerm . '%')
            ->orderBy('b.title', 'ASC');
    }

    public function findBySearch(string $searchTerm): array
    {
        return $this->createSearchQueryBuilder($searchTerm)
            ->getQuery()
            ->getResult();
    }
}
