<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class PageController extends AbstractController
{
    #[Route('/hello', name: 'page')]
    public function index(): Response
    {
        return $this->render('page/index.html.twig');
    }

    #[Route('/auth', name: 'auth')]
    #[IsGranted('ROLE_USER')]
    public function auth(): Response
    {
        return $this->render('page/index.html.twig');
    }

    
}
