<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoginPageController extends AbstractController
{
    #[Route('/api', name: 'app_login_page')]
    public function index(): Response
    {
        return $this->render('login_page/index.html.twig', [
            'controller_name' => 'LoginPageController',
        ]);
    }
}
