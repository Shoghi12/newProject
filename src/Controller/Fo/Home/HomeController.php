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

// $clients = $this->entityManager->createQueryBuilder()
//     ->select('c.nom, c.ville')
//     ->from('App\Entity\Client', 'c')
//     ->getQuery()
//     ->getArrayResult();


// $fournisseurs = $this->entityManager->createQueryBuilder()
//     ->select('f.nom, f.ville')
//     ->from('App\Entity\Fournisseur', 'f')
//     ->getQuery()
//     ->getArrayResult();


// $all = array_merge($clients, $fournisseurs);
// $unique = array_map("unserialize", array_unique(array_map("serialize", $all)));
// dd($all);








    // $dbalQb = $connection->createQueryBuilder();


    // $clientsQb = $connection->createQueryBuilder()
    //     ->select('nom', 'ville')
    //     ->from('client'); 


    // $fournisseursQb = $connection->createQueryBuilder()
    //     ->select('nom', 'ville')
    //     ->from('fournisseur');

 
$query = $this->clientRepository->searchBy(['union' => true, 'entityManager' => $this->entityManager, 'search' =>'p']);
dd($query);



    



  










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
