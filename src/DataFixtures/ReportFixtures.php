<?php

namespace App\DataFixtures;

use App\Entity\Report;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ReportFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
       for ($i = 0; $i < 10; $i++) {
            $user = $manager->getRepository(User::class)->find($i);
            $report = (new Report())
            ->setName("name$i")
            ->setDescription("mon $i description")
            ->setContenu("mon $i contenu")
            ->setCreated(new \DateTime())
            ->setUpdated(new \DateTime())
            ->setUserId($user)
            ->setStatus(true);
            
            $manager->persist($report);
        }  
        $manager->flush();
    }
}
