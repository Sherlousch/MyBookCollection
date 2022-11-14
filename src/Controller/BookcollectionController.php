<?php

namespace App\Controller;

use App\Entity\Bookcollection;
use App\Entity\Book;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class BookcollectionController extends AbstractController
{
    #[Route('/', name: 'app_bookcollection')]
    public function index(): Response
    {
        return $this->render('bookcollection/index.html.twig', [
            'controller_name' => 'BookcollectionController',
        ]);
    }

    /**
    * Lists all Bookcollections entities.
    *
    * @Route("/bookcollection/list", name = "bookcollection_list", methods="GET")
    */
    public function listAction(ManagerRegistry $doctrine): Response
    {
        $entityManager= $doctrine->getManager();
        $bookcollections = $entityManager->getRepository(Bookcollection::class)->findAll();

        dump($bookcollections);

        return $this->render('bookcollection/list.html.twig',
            [ 'controller_name' => 'BookcollectionController',
            'bookcollections' => $bookcollections ]
            );
    }

    /**
    * Show a bookcollection
    * 
    * @Route("/bookcollection/{id}", name="bookcollection_show", requirements={"id"="\d+"})
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
}
