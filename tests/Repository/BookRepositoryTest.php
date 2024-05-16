<?php

namespace App\Repository;

use App\Entity\Book;
use App\Repository\BookRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class BookRepositoryTest extends KernelTestCase
{
    /**
     * @var ManagerRegistry
     */
    private $managerRegistry;

    /**
     * @var \Doctrine\Persistence\ObjectManager
     */
    private $entityManager;

    /**
     * @var BookRepository
     */
    private $bookRepository;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();
        $container = $kernel->getContainer();
        
        $doctrine = $container->get('doctrine');
        if ($doctrine instanceof ManagerRegistry) {
            $this->managerRegistry = $doctrine;
        }

        $this->entityManager = $this->managerRegistry->getManager();
        $this->bookRepository = new BookRepository($this->managerRegistry);
    }

    public function testGetByIsbn(): void
    {
        $isbn = "2468013579";

        $book = new Book();
        $book->setName("Book");
        $book->setAuthor("Author");
        $book->setIsbn($isbn);
        $this->entityManager->persist($book);
        $this->entityManager->flush();

        $theBook = $this->bookRepository->getByIsbn($isbn);

        $this->assertInstanceOf(Book::class, $theBook);
        $this->assertEquals($isbn, $theBook->getIsbn());
        $this->assertEquals("Book", $theBook->getName());
        $this->assertEquals("Author", $theBook->getAuthor());

        $this->entityManager->remove($book);
        $this->entityManager->flush();
    }
}
