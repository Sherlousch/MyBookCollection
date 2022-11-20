<?php

namespace App\Controller;

use App\Entity\Bookcollection;
use App\Repository\BookcollectionRepository;
use App\Entity\Book;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
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
    * @Route("/{id}", name="bookcollection_show", requirements={"id"="\d+"})
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
