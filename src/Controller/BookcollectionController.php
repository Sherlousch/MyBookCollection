<?php

namespace App\Controller;

use App\Entity\Bookcollection;
use App\Repository\BookcollectionRepository;
use App\Entity\Book;
use App\Entity\Membre;
use App\Repository\MembreRepository;
use App\Form\BookcollectionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Doctrine\Persistence\ManagerRegistry;

#[Route('/bookcollection')]
class BookcollectionController extends AbstractController
{
    #[Route('/', name: 'app_bookcollection_index')]
    public function index(BookcollectionRepository $bookcollectionRepository): Response
    {
        return $this->render('bookcollection/index.html.twig', [
            'bookcollections' => $bookcollectionRepository->findAll(),
        ]);
    }

    /**
    * Show a bookcollection
    * 
    * @Route("/{id}", name="app_bookcollection_show", requirements={"id"="\d+"})
    *    note that the id must be an integer, above
    *    
    * @param Integer $id
    */
    public function showAction(ManagerRegistry $doctrine, $id)
    {
        $BookcollectionRepo = $doctrine->getRepository(Bookcollection::class);
        $bookcollection = $BookcollectionRepo->find($id);

        if (!$bookcollection) {
            throw $this->createNotFoundException('The bookcollection does not exist');
        }

        dump($bookcollection);        
        
        return $this->render('bookcollection/show.html.twig',
            [ 'bookcollection' => $bookcollection, ]
            );
    }

    #[Route('/{id}/edit', name: 'app_bookcollection_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Bookcollection $bookcollection, BookcollectionRepository $bookcollectionRepository): Response
    {
        $form = $this->createForm(BookcollectionType::class, $bookcollection);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bookcollectionRepository->save($bookcollection, true);

            return $this->redirectToRoute('app_bookcollection_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('bookcollection/edit.html.twig', [
            'bookcollection' => $bookcollection,
            'form' => $form,
        ]);
    }

    #[Route('/new/{membre_id}', name: 'app_bookcollection_new', methods: ['GET', 'POST'])]
    #[ParamConverter('membre', class: Membre::class, options: ['id' => 'membre_id'])]
    public function new(Request $request, BookcollectionRepository $bookcollectionRepository, Membre $membre): Response
    {
        $bookcollection = new Bookcollection();
        $bookcollection->setMembre($membre);
        $form = $this->createForm(BookcollectionType::class, $bookcollection);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bookcollectionRepository->save($bookcollection, true);
            
            // Make sure message will be displayed after redirect
            $this->addFlash('message', 'bien ajouté');
            // $this->addFlash() is equivalent to $request->getSession()->getFlashBag()->add()
            // or to $this->get('session')->getFlashBag()->add();
   

            return $this->redirectToRoute('app_bookcollection_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('bookcollection/new.html.twig', [
            'bookcollection' => $bookcollection,
            'form' => $form,
        ]);
    }
}
