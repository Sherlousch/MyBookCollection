<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookcollectionController extends AbstractController
{
    #[Route('/', name: 'app_bookcollection')]
    public function index(): Response
    {
        return $this->render('bookcollection/index.html.twig', [
            'controller_name' => 'BookcollectionController',
        ]);
    }
}
