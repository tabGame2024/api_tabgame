<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BienvenueControlleclearController extends AbstractController
{
    #[Route('/bienvenue/controlleclear', name: 'app_bienvenue_controlleclear')]
    public function index(): Response
    {
        return $this->render('bienvenue_controlleclear/index.html.twig', [
            'controller_name' => 'BienvenueControlleclearController',
        ]);
    }
}
