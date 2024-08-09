<?php

namespace Tests\Service;

use App\Entity\Author;
use App\Entity\Book;
use PHPUnit\Framework\TestCase;

class AuthorTest extends TestCase
{
    public function testGetAuthor()
    {
        $author = new Author();
        $author->setName('Marcel Pagnol');

        $this->assertEquals('Marcel Pagnol', $author->getName());
    }

}