<?php

namespace App\Controller;

use App\Entity\Bookcase;
use App\Form\BookcaseType;
use App\Repository\BookcaseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ObjectManager;

#[Route('/bookcase')]
class BookcaseController extends AbstractController
{
    #[Route('/', name: 'app_bookcase_index', methods: ['GET'])]
    public function index(BookcaseRepository $bookcaseRepository): Response
    {
        return $this->render('bookcase/index.html.twig', [
            'bookcases' => $bookcaseRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_bookcase_new', methods: ['GET', 'POST'])]
    public function new(Request $request, BookcaseRepository $bookcaseRepository): Response
    {
        $bookcase = new Bookcase();
        $form = $this->createForm(BookcaseType::class, $bookcase);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bookcaseRepository->save($bookcase, true);
            
            // Make sure message will be displayed after redirect
            $this->addFlash('message', 'bien ajouté');
            // $this->addFlash() is equivalent to $request->getSession()->getFlashBag()->add()
            // or to $this->get('session')->getFlashBag()->add();
   

            return $this->redirectToRoute('app_bookcase_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('bookcase/new.html.twig', [
            'bookcase' => $bookcase,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_bookcase_show', methods: ['GET'])]
    public function show(Bookcase $bookcase): Response
    {
        return $this->render('bookcase/show.html.twig', [
            'bookcase' => $bookcase,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_bookcase_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Bookcase $bookcase, BookcaseRepository $bookcaseRepository): Response
    {
        $form = $this->createForm(BookcaseType::class, $bookcase);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bookcaseRepository->save($bookcase, true);

            return $this->redirectToRoute('app_bookcase_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('bookcase/edit.html.twig', [
            'bookcase' => $bookcase,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_bookcase_delete', methods: ['POST'])]
    public function delete(Request $request, Bookcase $bookcase, BookcaseRepository $bookcaseRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bookcase->getId(), $request->request->get('_token'))) {
            $bookcaseRepository->remove($bookcase, true);
        }

        return $this->redirectToRoute('app_bookcase_index', [], Response::HTTP_SEE_OTHER);
    }
}
