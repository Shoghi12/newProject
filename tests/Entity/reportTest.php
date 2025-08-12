<?php

namespace App\Tests\Entity;

use App\Entity\Report;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class reportTest extends KernelTestCase
{
    public function testEntityreport(): void
    {
        $this->assertTrue(class_exists(Report::class), 'La classe report doit exister.');

          // Vous pouvez également vérifier que l'entité a les attributs attendus  
        $reflectionClass = new \ReflectionClass(Report::class);
        $this->assertTrue($reflectionClass->hasProperty('id'), 'La propriété id doit exister.');
               $idProperty = $reflectionClass->getProperty('id');
        $this->assertTrue($idProperty->getType() == '?int', 'Le type de id doit être un integer.');

        $this->assertTrue($reflectionClass->hasProperty('name'), 'La propriété name doit exister.');
               $nameProperty = $reflectionClass->getProperty('name');
        $this->assertTrue($nameProperty->getType() == '?string', 'Le type de name doit être un string.');

        $this->assertTrue($reflectionClass->hasProperty('description'), 'La propriété description doit exister.');
               $descriptionProperty = $reflectionClass->getProperty('description');
        $this->assertTrue($descriptionProperty->getType() == '?string', 'Le type de description doit être un string.');

        $this->assertTrue($reflectionClass->hasProperty('contenu'), 'La propriété content doit exister.');
               $contentProperty = $reflectionClass->getProperty('contenu');
        $this->assertTrue($contentProperty->getType() == '?string', 'Le type de content doit être un string.');

        $this->assertTrue($reflectionClass->hasProperty('user_id'), 'La propriété user_id doit exister.');
               $contentProperty = $reflectionClass->getProperty('user_id');
        $type = $contentProperty->getType();
        $this->assertTrue($type && $type->getName() === 'App\Entity\User', 'Le type user_id doit être une relation.');

        $this->assertTrue($reflectionClass->hasProperty('created'), 'La propriété created doit exister.');
               $createdProperty = $reflectionClass->getProperty('created');
        $this->assertTrue($createdProperty->getType() == '?DateTime', 'Le type de created doit être un datetime.');

        $this->assertTrue($reflectionClass->hasProperty('updated'), 'La propriété updated doit exister.');
               $updatedProperty = $reflectionClass->getProperty('updated');
        $this->assertTrue($updatedProperty->getType() == '?DateTime', 'Le type de updated doit être un datetime.');

        $this->assertTrue($reflectionClass->hasProperty('status'), 'La propriété status doit exister.');
               $statusProperty = $reflectionClass->getProperty('status');
        $this->assertTrue($statusProperty->getType() == '?bool', 'Le type de status doit être un boolean.');
    }

    public function testGetIdReport(){
        $report = static::getContainer()->get('doctrine.orm.entity_manager')->find(Report::class, 1);
        $this->assertTrue("name0" === $report->getName());
    }

    public function testPostReport(){
        $entityManager = static::getContainer()->get('doctrine.orm.entity_manager');
        $report = (new Report())
            ->setName("nameTest")
            ->setDescription("descriptionTest")
            ->setContenu("contenuTest")
            ->setCreated(new \DateTime())
            ->setUpdated(new \DateTime())
            ->setUserId(null)
            ->setStatus(true);

        $entityManager->persist($report);
        $entityManager->flush();

        $report = $entityManager->find(Report::class, $report->getId());

        $this->assertNotNull($report, 'Le report doit exister.');
    }

    public function testPatchReport(){
        $entityManager = static::getContainer()->get('doctrine.orm.entity_manager');
        $report = $entityManager->getRepository(Report::class)->find(3);
        $this->assertNotNull($report, 'Le report doit exister.');
        $report->setName("nameTestUpdated");
        $entityManager->flush();
        $report = $entityManager->find(Report::class, 3);
        $this->assertEquals("nameTestUpdated", $report->getName(), 'Le report doit exister.');
    }

    public function testDeleteReport(){
        $entityManager = static::getContainer()->get('doctrine.orm.entity_manager');
        $report = $entityManager->getRepository(Report::class)->find(4);
        $this->assertNotNull($report, 'Le report doit exister.');
        $entityManager->remove($report);
        $entityManager->flush();
        $report = $entityManager->find(Report::class, 4);
        $this->assertNull($report, 'Le report doit être supprimé.');
    }
}

