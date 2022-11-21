<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Form\BookType;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Book;
use App\Repository\BookRepository;
use App\Entity\Genre;
use App\Entity\Bookcollection;

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

    #[Route('/new/{bookcollection_id}', name: 'app_book_new', methods: ['GET', 'POST'])]
    #[ParamConverter('bookcollection', class: Bookcollection::class, options: ['id' => 'bookcollection_id'])]
    public function new(Request $request, BookRepository $bookRepository, Bookcollection $bookcollection): Response
    {
        $book = new Book();
        $book->setCollection($bookcollection);
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bookRepository->save($book, true);
            
            // Make sure message will be displayed after redirect
            $this->addFlash('message', 'bien ajouté');
            // $this->addFlash() is equivalent to $request->getSession()->getFlashBag()->add()
            // or to $this->get('session')->getFlashBag()->add();
   

            return $this->redirectToRoute('app_book_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('book/new.html.twig', [
            'book' => $book,
            'form' => $form,
        ]);
    }


    /**
    * Show a book
    * 
    * @Route("/{id}", name="app_book_show", requirements={"id"="\d+"})
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
    
    #[Route('/{id}/edit', name: 'app_book_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Book $book, BookRepository $bookRepository): Response
    {
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bookRepository->save($book, true);

            return $this->redirectToRoute('app_book_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('book/edit.html.twig', [
            'book' => $book,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_book_delete', methods: ['POST'])]
    public function delete(Request $request, Book $book, BookRepository $bookRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$book->getId(), $request->request->get('_token'))) {
            $bookRepository->remove($book, true);
        }

        return $this->redirectToRoute('app_book_index', [], Response::HTTP_SEE_OTHER);
    }
}
