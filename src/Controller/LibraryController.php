<?php

namespace App\Controller;

use App\Entity\Library;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\LibraryRepository;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class LibraryController extends AbstractController
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
        LibraryRepository $LibraryRepository,
        ManagerRegistry $doctrine,
        Request $request
    ): Response {
        $entityManager = $doctrine->getManager();

        $title = $request->request->get('booktitle');
        $author = $request->request->get('bookauthor');
        $isbn = $request->request->get('bookisbn');
        $imageFile = $request->files->get('img');
        $filename = "";

        if ($imageFile) {
            $img_directory = $this->getParameter('img_directory');

            if($imageFile->guessExtension()) {
                $filename = md5(uniqid()) . '.' . $imageFile->guessExtension();
                $imageFile->move(
                $img_directory,
                $filename
            );
            } else {
                $filename = $request->request->get('img');
            }
        } 
        
        $book = new Library();
        $book->setTitle($title);
        $book->setAuthor($author);
        $book->setIsbn($isbn);
        $book->setImg($filename);

        $entityManager->persist($book);
        $entityManager->flush();

        return $this->redirectToRoute('library_view_all');
    }

    #[Route('/library/view', name: 'library_view_all', methods: ['GET'])]
    public function viewAllLibrary(
        libraryRepository $libraryRepository
    ): Response {
        $books = $libraryRepository->findAll();
    
        $data = [
            'books' => $books
        ];
    
        return $this->render('library/view.html.twig', $data);
    }

    #[Route('/library/view/{id}', name: 'library_by_id')]
    public function viewSingleBook(
        LibraryRepository $LibraryRepository,
        int $id
    ): Response {
        $book = $LibraryRepository->find($id);
    
        $data = [
            'book' => $book
        ];
    
        return $this->render('library/singleview.html.twig', $data);
        // return $this->json($data);
    }

    #[Route('/library/update', name: 'library_update', methods: ['POST'])]
    public function updateBook(
        LibraryRepository $LibraryRepository,
        ManagerRegistry $doctrine,
        Request $request,
    ): Response {
        $id = $request->request->get('bookid');
        $book = $LibraryRepository->find($id);
    
        if (!$book) {
            throw $this->createNotFoundException(
                'No book found for id ' . $id
            );
        }

        $title = $request->request->get('booktitle');
        $author = $request->request->get('bookauthor');
        $isbn = $request->request->get('bookisbn');
        // $img = $request->request->get('img');
    
        $book->setTitle($title);
        $book->setAuthor($author);
        // $book->setImg($img);
        $book->setIsbn($isbn);

        $entityManager = $doctrine->getManager();
        $entityManager->flush();
    
        return $this->redirectToRoute('library_view_all');
    }

    #[Route('/library/delete', name: 'library_delete', methods: ['POST'])]
    public function deleteBookById(
        LibraryRepository $LibraryRepository,
        ManagerRegistry $doctrine,
        Request $request
    ): Response {
        $entityManager = $doctrine->getManager();
        $id = $request->request->get('bookid');
        $book = $LibraryRepository->find($id);
    
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
        LibraryRepository $libraryRepository,
        ManagerRegistry $doctrine,
    ): Response {
        $entityManager = $doctrine->getManager();
        
        $books = $libraryRepository->findAll();
        
        foreach ($books as $book) {
            $entityManager->remove($book);
        }
        
        $entityManager->flush();
    
        return $this->redirectToRoute('library_view_all');
    }   
}
