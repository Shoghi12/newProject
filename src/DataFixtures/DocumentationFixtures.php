<?php

namespace App\DataFixtures;

use App\Entity\Documentation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class DocumentationFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
     for ($i = 0; $i < 10; $i++) {
            $documentation = (new Documentation())
            ->setName("name$i")
            ->setImage("mon $i image")
            ->setDescription("mon $i description")
            ->setCreated(new \DateTimeImmutable())
            ->setUpdated(new \DateTime())
            ->setStatus(true);
            $manager->persist($documentation);

        }  
        $manager->flush();
    }
}
