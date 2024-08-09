<?php

namespace Tests\Service;

use App\Entity\Author;
use App\Entity\Book;
use PHPUnit\Framework\TestCase;

class BookTest extends TestCase
{
    public function testGetBook()
    {
        $book = new Book();
        $book->setTitle('La Gloire de mon père');

        $this->assertEquals('La Gloire de mon père', $book->getTitle());
    }


    public function testSetBook()
    {
        $book = new Book();
        $book->setTitle('La Gloire de mon père');

        $this->assertEquals('La Gloire de mon père', $book->getTitle());
    }

   
   
}
