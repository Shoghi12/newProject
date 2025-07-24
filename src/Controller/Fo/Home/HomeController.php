<?php

namespace App\Controller\Fo\Home;

use App\Entity\Client;
use App\Repository\ClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\DBAL\Query\QueryBuilder;

final class HomeController extends AbstractController
{
    private $entityManager;
    public function __construct(
        EntityManagerInterface $entityManager,
        private ClientRepository $clientRepository
     )
    {
        $this->entityManager = $entityManager;
        $this->clientRepository = $clientRepository;
    }
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        $query = $this->clientRepository->searchBy(['union' => true, 'entityManager' => $this->entityManager, 'search' =>'An']);
        if($this->getUser()){
// dd($this->getUser());
        }
        // dd($query);

        return $this->render('Fo/home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    private function getEntities ($fields, $entity, $i)
    {
        $query = $this->entityManager->createQueryBuilder()
            ->select($fields)
            ->from($entity, $i)
            ->getQuery()
            ->getArrayResult();

        return $query;
    }

    

}
