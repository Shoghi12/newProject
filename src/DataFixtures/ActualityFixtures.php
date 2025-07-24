<?php

namespace App\DataFixtures;

use App\Entity\Actuality;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ActualityFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 10; $i++) {
            $actuality = (new Actuality())
            ->setName("name$i")
            ->setImage("mon $i image")
            ->setDescription("mon $i description")
            ->setContent("mon $i contenu")
            ->setCreated(new \DateTime())
            ->setUpdated(new \DateTime())
            ->setStatus(true);
            $manager->persist($actuality);

        }  
        $manager->flush();
    }
}