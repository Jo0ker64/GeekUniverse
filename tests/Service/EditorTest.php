<?php

namespace Tests\Service;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\Editor;
use PHPUnit\Framework\TestCase;

class EditorTest extends TestCase
{
    public function testGetEditor()
    {
        $editor = new Editor();
        $editor->setName('Folio');

        $this->assertEquals('Folio', $editor->getName());
    }

    public function testSetEditor()
    {
        $editor = new Editor();
        $editor->setName('Folio');

        $this->assertEquals('Folio', $editor->getName());
    }
}