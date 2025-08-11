<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class FormulaireController extends AbstractController
{
    public function __construct( public EntityManagerInterface $em){
        $this->em = $em;
    }
    #[Route('/contact', name: 'app_formulaire')]
    public function index(Request $request): Response
    {
       
         $contact= new Contact;
        // Create advice form
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           
            $this->em->persist($contact);
            $this->em->flush();
    
            return $this->redirectToRoute('app.fo.app_home');
        }
        $commit1 = null;
        return $this->render('formulaire/index.html.twig', [
            'form' => $form->createView(),
            'contact' => $contact, 
        ]);
    }
}
