<?php

namespace App\Tests\Repository;

use App\Entity\Documentation;
use App\Repository\DocumentationRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DocumentationRepositoryTest extends KernelTestCase
{
    public function testSomething(): void
    {
        $kernel = self::bootKernel();

        $this->assertSame('test', $kernel->getEnvironment());
        // $routerService = static::getContainer()->get('router');
        // $myCustomService = static::getContainer()->get(CustomService::class);
    }

    public function testFindByNameDocumentation() {
        self::bootKernel();

        $entityManager = self::$kernel->getContainer()
        ->get('doctrine')
        ->getManager();

        $DocumentationRepository = $entityManager->getRepository(Documentation::class);

        $documentation = new Documentation();
        $documentation->setName("Lastname")
                      ->setImage("Lastimage")
                      ->setDescription("Lastdescription")
                      ->setCreated(new \DateTimeImmutable())
                      ->setUpdated(new \DateTime())
                      ->setStatus(true);

        $entityManager->persist($documentation);
        $entityManager->flush();

        $foundDocumentation = $DocumentationRepository->findByName('Lastname');

        $this->assertNotNull($foundDocumentation);
        $this->assertEquals('Lastname', $foundDocumentation->getName());

        $entityManager->remove($foundDocumentation);
        $entityManager->flush();

    }

    public function testFindByStatusTrue(){
        self::bootKernel();

        $entityManager = self::$kernel->getContainer()
        ->get('doctrine')
        ->getManager();

        $DocumentationRepository = $entityManager->getRepository(Documentation::class);

         $foundDocumentation = $DocumentationRepository->findAllByStatusTrue();
  
         $this->assertCount(8, $foundDocumentation);
        
        foreach ($foundDocumentation as $doc) {
            $this->assertTrue($doc->isStatus(), 'Le document doit avoir le statut true');
        }

        //verifie que le resultat est du ASC
        $createdDates = array_map(fn($doc) => $doc->getCreated(), $foundDocumentation);
        $this->assertTrue($createdDates[0] <= $createdDates[1]);

    }

}
