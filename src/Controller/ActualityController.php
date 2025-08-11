<?php

namespace App\Controller;

use App\Entity\Actuality;
use App\Form\ActualityType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ActualityController extends AbstractController
{
    #[Route('/actuality', name: 'app_actuality')]
    public function index(): Response
    {
        return $this->render('actuality/index.html.twig', [
            'controller_name' => 'ActualityController',
        ]);
    }
    
    #[Route('/actuality/new', name: 'actuality.new')]
    #[Route('/actuality/edit/{id}', name: 'actuality.edit')]
    public function action(Request $request, EntityManagerInterface $entityManager, Actuality $actuality = null): Response
    {
        if (!$actuality) {
            $actuality = new Actuality();
        }

        $form = $this->createForm(ActualityType::class, $actuality);
        $form->handleRequest($request);

          if ($form->isSubmitted() && $form->isValid()) {
            
            $user = $this->getUser();

            if ($user) {
                $actuality->setUserId($user);
            } 
            
            $actuality->setUpdated(new \DateTime());
        
            $entityManager->persist($actuality);
            $entityManager->flush();
            
            return $this->redirectToRoute('app.fo.app_home');
        }

        return $this->render('actuality/action.html.twig',[
            'form' => $form->createView(),
            'actuality' => $actuality,
        ]);
    }

    #[Route('/actuality/delete/{id}', name: 'actuality.delete')]
    public function deleteActuality(EntityManagerInterface $entityManager, Actuality $actuality): Response
    {
        if ($actuality) {
            $entityManager->remove($actuality);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app.fo.app_home');
    }

    


}
