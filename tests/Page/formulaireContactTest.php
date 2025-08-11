<?php

namespace App\tests\page;

use App\Entity\Documentation;
use App\Repository\DocumentationRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class formulaireContactTest extends WebTestCase
{
    public function testContact(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/contact');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h2', 'CONTACT US');

        $input = $crawler->filter('.fullname');
        $this->assertEquals(1, count($input));

        $submitButton = $crawler->selectButton('SEND'); 
        $form = $submitButton->form();

        $form["contact[name]"] = "myName";
        $form["contact[email]"] = "myEmail@gmail.com";
        $form["contact[phone]"] = "12345677";
   
        $client->submit($form);


        $client->followRedirect();

        $this->assertEquals(1, count($submitButton));
    }

    public function testDocumentationFormulaire(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/documentation');

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        // $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h2', 'ADD DOCUMENTATION');

        //verifie si le bouton "Envoyer" existe
        $this->assertGreaterThan(0, $crawler->selectButton('Envoyer')->count());
       
        $submitButton = $crawler->selectButton('Envoyer'); 
        $form = $submitButton->form();

        $form["documentation[name]"] = "FormulaireName";
        $form["documentation[description]"] = "FormulaireDescription";
        $form["documentation[status]"] = true;

        $client->submit($form);

        $entityManager = self::$kernel->getContainer()
        ->get('doctrine')
        ->getManager();

        $DocumentationRepository = $entityManager->getRepository(Documentation::class);

        $foundDocumentation = $DocumentationRepository->findByName('FormulaireName');
        $this->assertNotNull($foundDocumentation);

        $entityManager->remove($foundDocumentation);
        $entityManager->flush();

        $client->followRedirect();
    }

    public function testUpdatePost(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/documentation/1/edit');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h2', 'EDIT DOCUMENTATION');

        $submitButton = $crawler->selectButton('Envoyer'); 
        $form = $submitButton->form();

        $form["documentation[name]"] = "UpdatedName";
        $form["documentation[description]"] = "UpdatedDescription";
        $form["documentation[status]"] = true;

        $client->submit($form);

        $entityManager = self::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        $DocumentationRepository = $entityManager->getRepository(Documentation::class);

        $updatedDocumentation = $DocumentationRepository->findByName('UpdatedName');
        $this->assertNotNull($updatedDocumentation);

        // Clean up
        $entityManager->remove($updatedDocumentation);
        $entityManager->flush();

        $client->followRedirect();
    }
}
