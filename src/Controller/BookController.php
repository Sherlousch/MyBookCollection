<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Book;
use App\Repository\BookRepository;
use App\Entity\Genre;

#[Route('/book')]
class BookController extends AbstractController
{
    #[Route('/', name: 'app_book_index')]
    public function index(BookRepository $bookRepository): Response
    {
        return $this->render('book/index.html.twig', [
            'books' => $bookRepository->findAll(),
        ]);
    }

    /**
    * Show a book
    * 
    * @Route("/{id}", name="book_show", requirements={"id"="\d+"})
    *    note that the id must be an integer, above
    *    
    * @param Integer $id
    */
    public function showAction(ManagerRegistry $doctrine, $id)
    {
        $BookRepo = $doctrine->getRepository(Book::class);
        $book = $BookRepo->find($id);

        if (!$book) {
            throw $this->createNotFoundException('The book does not exist');
        }

        dump($book);        
        
        return $this->render('book/show.html.twig',
            [ 'book' => $book, ]
            );
    }    
}
