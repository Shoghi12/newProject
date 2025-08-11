<?php

namespace App\Tests\Entity;

use App\Entity\Documentation;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DocumentationTest extends KernelTestCase
{
    public function testSomething(): void
    {
        $kernel = self::bootKernel();

        $this->assertSame('test', $kernel->getEnvironment());
        // $routerService = static::getContainer()->get('router');
        // $myCustomService = static::getContainer()->get(CustomService::class);
    }

      public function testDocumentationEntityExists(): void  
    {
        // Vérifiez que la classe User est définie  
        $this->assertTrue(class_exists(Documentation::class), 'La classe User doit exister.');

        // Vous pouvez également vérifier que l'entité a les attributs attendus  
        $reflectionClass = new \ReflectionClass(Documentation::class);
        $this->assertTrue($reflectionClass->hasProperty('id'), 'La propriété id doit exister.');
               $idProperty = $reflectionClass->getProperty('id');
        $this->assertTrue($idProperty->getType() == '?int', 'Le type de id doit être un integer.');

        $this->assertTrue($reflectionClass->hasProperty('name'), 'La propriété name doit exister.');
               $nameProperty = $reflectionClass->getProperty('name');
        $this->assertTrue($nameProperty->getType() == '?string', 'Le type de name doit être un string.');

        $this->assertTrue($reflectionClass->hasProperty('image'), 'La propriété image doit exister.');
               $imageProperty = $reflectionClass->getProperty('image');
        $this->assertTrue($imageProperty->getType() == '?string', 'Le type de image doit être un string.');

        $this->assertTrue($reflectionClass->hasProperty('description'), 'La propriété description doit exister.');
               $descriptionProperty = $reflectionClass->getProperty('description');
        $this->assertTrue($descriptionProperty->getType() == '?string', 'Le type de description doit être un string.');

        $this->assertTrue($reflectionClass->hasProperty('created'), 'La propriété created doit exister.');
               $createdProperty = $reflectionClass->getProperty('created');
        $this->assertTrue($createdProperty->getType() == '?DateTimeImmutable', 'Le type de created doit être un datetime immutable.');

        $this->assertTrue($reflectionClass->hasProperty('updated'), 'La propriété updated doit exister.');
               $updatedProperty = $reflectionClass->getProperty('updated');
        $this->assertTrue($updatedProperty->getType() == '?DateTime', 'Le type de updated doit être un datetime.');

        $this->assertTrue($reflectionClass->hasProperty('status'), 'La propriété status doit exister.');
               $statusProperty = $reflectionClass->getProperty('status');
        $this->assertTrue($statusProperty->getType() == '?bool', 'Le type de status doit être un boolean.');
    }
}
