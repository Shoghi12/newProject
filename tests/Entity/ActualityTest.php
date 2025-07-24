<?php

namespace App\Tests\Entity;

use App\Entity\Actuality;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ActualityTest extends KernelTestCase
{
    //test si l'entité existe ou pas
    public function testUserEntityExists(): void  
    {
        // Vérifiez que la classe User est définie  
        $this->assertTrue(class_exists(Actuality::class), 'La classe User doit exister.');

        // Vous pouvez également vérifier que l'entité a les attributs attendus  
        $reflectionClass = new \ReflectionClass(Actuality::class);
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

        $this->assertTrue($reflectionClass->hasProperty('content'), 'La propriété content doit exister.');
               $contentProperty = $reflectionClass->getProperty('content');
        $this->assertTrue($contentProperty->getType() == '?string', 'Le type de content doit être un string.');

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

    
   
   public function testActualityWithValidData()
{
    // Date fixe pour la cohérence du test
    $date = new \DateTime();

    // Création de l'objet Actuality avec des données de test
    $actuality = new Actuality();
    $actuality
        ->setName('Test Name')
        ->setImage('test-image.png')
        ->setDescription('Ceci est une description de test')
        ->setContent('Contenu de test')
        ->setCreated($date)
        ->setUpdated($date)
        ->setStatus(true);

    // Vérification que chaque propriété a été correctement stockée
    $this->assertEquals('Test Name', $actuality->getName());
    $this->assertEquals('test-image.png', $actuality->getImage());
    $this->assertEquals('Ceci est une description de test', $actuality->getDescription());
    $this->assertEquals('Contenu de test', $actuality->getContent());
    $this->assertEquals($date, $actuality->getCreated());
    $this->assertEquals($date, $actuality->getUpdated());
    $this->assertTrue($actuality->isStatus());
}

public function getEntityActuality (): Actuality
    {
        return $code = (new Actuality())
            ->setName('name')
            ->setImage('mon image')
            ->setDescription('mon description')
            ->setContent('mon contenu')
            ->setCreated(new \DateTime())
            ->setUpdated(new \DateTime())
            ->setStatus(true);
    }

public function testValidActualityEntity(){
       self::bootKernel();
       $container = static::getContainer();

       $date = new \DateTime();

       $actuality = $this->getEntityActuality();

       $errors = $container->get('validator')->validate($actuality);
       $this->assertCount(0, $errors);
}
 public function testGetNameEntityActuality(){
       $actuality = static::getContainer()->get('doctrine.orm.entity_manager')->find(actuality::class, 11);
       $this->assertTrue("name0" === $actuality->getName());
 }

  public function assertHasErrors(Actuality $actuality, int $number = 0)
    {
        self::bootKernel();
        $errors = self::getContainer()->get('validator')->validate($actuality);
        $messages = [];
        /** @var ConstraintViolation $error */
        foreach ($errors as $error) {
            $messages[] = $error->getPropertyPath() . ' => ' . $error->getMessage();
        }
         $this->assertCount($number, $errors, implode(', ', $messages));
    }


    public function testValidEntityActuality ()
    {
       $this->assertHasErrors($this->getEntityActuality(), 0);
    }

    public function testInvalidBlankDescriptionEntityActuality ()
    {
        $this->assertHasErrors($this->getEntityActuality()->setDescription(''), 1);
    }
}