<?php

namespace App\Entity;

use App\Entity\Book;
use PHPUnit\Framework\TestCase;

class BookTest extends TestCase
{
    public function testId():void
    {
        $book = new Book();
        $this->assertNull($book->getId());
    }

    public function testName():void
    {
        $book = new Book();
        $this->assertNull($book->getName());

        $book->setName("Book");
        $this->assertEquals("Book", $book->getName());
    }

    public function testAuthor():void
    {
        $book = new Book();
        $this->assertNull($book->getAuthor());

        $book->setAuthor("Author");
        $this->assertEquals("Author", $book->getAuthor());
    }

    public function testIsbn():void
    {
        $book = new Book();
        $this->assertNull($book->getIsbn());

        $book->setIsbn("1357924680");
        $this->assertEquals("1357924680", $book->getIsbn());
    }

    public function testImg():void
    {
        $book = new Book();
        $this->assertNull($book->getImg());

        $book->setImg("haha.jpg");
        $this->assertEquals("haha.jpg", $book->getImg());
    }
}