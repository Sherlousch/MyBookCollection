<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Book;


class BookController extends AbstractController
{
    #[Route('/book', name: 'app_book')]
    public function index(): Response
    {
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }

    /**
    * Lists all Books entities.
    *
    * @Route("/book/list", name = "book_list", methods="GET")
    */
    public function listAction(ManagerRegistry $doctrine): Response
    {
        $entityManager= $doctrine->getManager();
        $books = $entityManager->getRepository(Book::class)->findAll();

        dump($books);

        return $this->render('book/list.html.twig',
            [ 'books' => $books ]
            );
    }

    /**
    * Show a book
    * 
    * @Route("/book/{id}", name="book_show", requirements={"id"="\d+"})
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
