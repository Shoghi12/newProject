<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class LanguageController extends AbstractController
{
    private $requestStack;

    public function __construct(RequestStack $requestStack){
        $this->requestStack = $requestStack;
    }
    #[Route('/language', name: 'app_language')]
    public function index(): Response
    {
        $request = $this->requestStack->getCurrentRequest();

        if ($request){
            $request->getSession()->set('_locale', 'en');
            $request->setLocale('en');
            $locale = $request->getLocale();
            $this->addFlash('success', "Current locale is: $locale");
            dd($locale);
        } 
        return $this->render('language/index.html.twig', [
            'controller_name' => 'LanguageController',
        ]);
    }
}
