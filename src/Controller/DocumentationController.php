<?php

namespace App\Controller;

use App\Entity\Documentation;
use App\Form\DocumentationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DocumentationController extends AbstractController
{
    public function __construct(public EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/documentation', name: 'app_documentation')]
    public function index(Request $request): Response
    {
        $documentation = new Documentation();

        $form = $this->createForm(DocumentationType::class, $documentation);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           
            $this->em->persist($documentation);
            $this->em->flush();
    
            return $this->redirectToRoute('app.fo.app_home');
        }

        return $this->render('formulaire/documentation/index.html.twig', [
            'form' => $form->createView(),
            'documentation' => $documentation,
        ]);
    }

      #[Route('/documentation/new', name: 'documentation.new')]
    #[Route('/documentation/edit/{id}', name: 'documentation.edit')]
    public function action(Request $request, EntityManagerInterface $entityManager, Documentation $documentation = null): Response
    {
        if (!$documentation) {
            $documentation = new Documentation();
        }

        $form = $this->createForm(DocumentationType::class, $documentation);
        $form->handleRequest($request);

          if ($form->isSubmitted() && $form->isValid()) {
            
            $user = $this->getUser();

            if ($user) {
                $documentation->setUserId($user);
            } 
            
            $documentation->setUpdated(new \DateTime());
        
            $entityManager->persist($documentation);
            $entityManager->flush();
            
            return $this->redirectToRoute('app.fo.app_home');
        }

        return $this->render('documentation/action.html.twig',[
            'form' => $form->createView(),
            'documentation' => $documentation,
        ]);
    }

       #[Route('/documentation/delete/{id}', name: 'documentation.delete')]
    public function deleteDocumentation(EntityManagerInterface $entityManager, Documentation $documentation): Response
    {
        if ($documentation) {
            $entityManager->remove($documentation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app.fo.app_home');
    }
}
