<?php

namespace App\Controller;

use App\Entity\Book;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\BookRepository;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class BookController extends AbstractController
{
    #[Route('/library', name: 'app_library')]
    public function index(): Response
    {
        return $this->render('library/index.html.twig', [
            'controller_name' => 'LibraryController',
        ]);
    }

    #[Route('/library/create', name: 'library_create')]
    public function createBook(
    ): Response {

        return $this->render('library/createview.html.twig');
    }

    #[Route('/library/create/book', name: 'library_create_post', methods: ['POST'])]
    public function createBookPost(
        // LibraryRepository $libraryRepository,
        ManagerRegistry $doctrine,
        Request $request
    ): Response {
        $entityManager = $doctrine->getManager();

        $title = $request->request->getString('booktitle');
        $author = $request->request->getString('bookauthor');
        $isbn = $request->request->getString('bookisbn');
        $imageFile = $request->files->get('img');
        $filename = "";

        if ($imageFile instanceof UploadedFile) {
            $imgDirectory = $this->getParameter('img_directory');

            if (is_string($imgDirectory)) {
                try {
                    if ($imageFile->guessExtension()) {
                        $filename = md5(uniqid()) . '.' . $imageFile->guessExtension();
                        $imageFile->move(
                            $imgDirectory,
                            $filename
                        );
                    }
                } catch (\Exception $e) {
                    $filename = "Book Image";
                }
            }
        }

        $book = new Book();
        $book->setName($title);
        $book->setAuthor($author);
        $book->setIsbn($isbn);
        $book->setImg($filename);

        $entityManager->persist($book);
        $entityManager->flush();

        return $this->redirectToRoute('library_view_all');
    }

    #[Route('/library/view', name: 'library_view_all', methods: ['GET'])]
    public function viewAllLibrary(
        BookRepository $BookRepository
    ): Response {
        $books = $BookRepository->findAll();

        $data = [
            'books' => $books
        ];

        return $this->render('library/view.html.twig', $data);
    }

    #[Route('/library/view/{id}', name: 'library_by_id')]
    public function viewSingleBook(
        BookRepository $BookRepository,
        int $id
    ): Response {
        $book = $BookRepository->find($id);

        $data = [
            'book' => $book,
        ];

        return $this->render('library/singleview.html.twig', $data);
        // return $this->json($data);
    }

    #[Route('/library/update', name: 'library_update', methods: ['POST'])]
    public function updateBook(
        BookRepository $BookRepository,
        ManagerRegistry $doctrine,
        Request $request,
    ): Response {
        $entityManager = $doctrine->getManager();
        $id = $request->request->get('bookid');
        $book = $BookRepository->find($id);

        if (!$book) {
            throw $this->createNotFoundException(
                'No book found for id ' . $id
            );
        }

        $title = $request->request->getString('booktitle');
        $author = $request->request->getString('bookauthor');
        $isbn = null;

        if ($isbn == null) {
            try {
                $isbn = $request->request->getString('bookisbn');
            } catch (\Exception $e) {
                $isbn = 1234567890;
            }
        }

        $book->setName($title);
        $book->setAuthor($author);
        $book->setIsbn($isbn);

        $entityManager->flush();

        return $this->redirectToRoute('library_view_all');
    }

    #[Route('/library/delete', name: 'library_delete', methods: ['POST'])]
    public function deleteBookById(
        BookRepository $BookRepository,
        ManagerRegistry $doctrine,
        Request $request
    ): Response {
        $entityManager = $doctrine->getManager();
        $id = $request->request->get('bookid');
        $book = $BookRepository->find($id);

        if (!$book) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        $entityManager->remove($book);
        $entityManager->flush();

        return $this->redirectToRoute('library_view_all');
    }

    #[Route('/library/deleteall', name: 'library_delete_all')]
    public function deleteAllBooks(
        BookRepository $BookRepository,
        ManagerRegistry $doctrine,
    ): Response {
        $entityManager = $doctrine->getManager();

        $books = $BookRepository->findAll();

        foreach ($books as $book) {
            $entityManager->remove($book);
        }

        $entityManager->flush();

        return $this->redirectToRoute('library_view_all');
    }

    #[Route('/api/library/books', name: 'api_show_all')]
    public function showAllProduct(
        BookRepository $BookRepository,
    ): Response {
        $books = $BookRepository
            ->findAll();

        $response = $this->json($books);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route('/api/library/books/{isbn}', name: 'library_by_id_api')]
    public function apiViewSingleBook(
        BookRepository $BookRepository,
        int $isbn
    ): Response {
        $book = $BookRepository->getByIsbn($isbn);

        $response = $this->json($book);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }
}
