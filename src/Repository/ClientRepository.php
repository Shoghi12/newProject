<?php

namespace App\Repository;

use App\Entity\Client;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Client>
 */
class ClientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Client::class);
    }

       /**
        * @return Client[] Returns an array of Client objects
        */
       public function searchBy($parameters = [])
       {
         if (array_key_exists("union", $parameters)) 
            {
                $connection = $parameters['entityManager']->getConnection();
                $query = $connection->createQueryBuilder()
                    ->select('*')
                    ->from('(' . $connection->createQueryBuilder()
                        ->select('nom', 'ville', '\'client\' AS type')
                        ->from('client')->getSQL() . ' UNION ALL ' . $connection->createQueryBuilder()
                        ->select('nom', 'ville', '\'fournisseur\' AS type')
                        ->from('fournisseur')->getSQL() . ' UNION ALL ' . $connection->createQueryBuilder()
                        ->select('nom', 'ville', '\'agent\' AS type')
                        ->from('agent')->getSQL() . ')', 'union_result')
                        ->where('nom LIKE :nom')
                        ->setParameter('nom', '%' . $parameters['search'] . '%')
                        ->executeQuery()
                        ->fetchAllAssociative();

                return $query;
           }
       }

  
}
