<?php

namespace App\Repository;

use App\Entity\Documentation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Documentation>
 */
class DocumentationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Documentation::class);
    }

    public function findByName(string $name): ?Documentation
    {
        return $this->findOneBy(['name' => $name]);
    }

    public function findAllByStatusTrue(): array
    {
        $query = $this->createQueryBuilder('d')
            ->where('d.status = :status')
            ->orderBy('d.created', 'ASC')
            ->setParameter('status', true);
      
        return $query
            ->getQuery()
            ->getResult();
    }
}
