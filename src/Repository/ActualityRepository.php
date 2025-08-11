<?php

namespace App\Repository;

use App\Entity\Actuality;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Actuality>
 */
class ActualityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Actuality::class);
    }

    public function findById(int $id): ?Actuality
    {
        return $this->findOneBy(['id' => $id]);
    }

    public function findByName(string $name): ?Actuality
    {
        return $this->findOneBy(['name' => $name]);
    }

}
