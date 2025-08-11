<?php

namespace App\Tests\Controller;

use App\Entity\Actuality;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

final class ActualityControllerTest extends WebTestCase
{
    public function testIndex(): void
    {
        $client = static::createClient();
        $client->request('GET', '/actuality');

        self::assertResponseIsSuccessful();
    }

    public function testNewActualityController(): void{
        $client = static::createClient();
        $crawler = $client->request('GET', '/actuality/new');
        
        $this->assertResponseStatusCodeSame(200);
       
        $this->assertSelectorTextContains('h2', 'ADD ACTUALITY');

        self::assertResponseIsSuccessful();

        $actualityNew = $actualityNew ?? new Actuality();
        $this->assertNotNull($actualityNew, 'Actuality entity cannot be null');

      

        $submitButton = $crawler->selectButton('Envoyer'); 
        $form = $submitButton->form();

        $form["actuality[name]"] = "UpdatedName";
        $form["actuality[description]"] = "UpdatedDescription";
        $form["actuality[content]"] = "UpdatedContent";
        $form["actuality[status]"] = true;


        //Edit
        $urlGenerator = $client->getContainer()->get('router');
        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');

        $actuality = $entityManager->find(Actuality::class, 1);
        $crawler2 = $client->request(
            Request ::METHOD_GET,
            $urlGenerator->generate('actuality.edit', ['id' => $actuality->getId()])
        );

        $this->assertResponseIsSuccessful();

        $submitButton = $crawler2->selectButton('Envoyer'); 
        $form = $submitButton->form();

        $form["actuality[name]"] = "UpdatedNamerrrrrrr";

        $client->submit($form);

        $this->assertResponseStatusCodeSame(HttpFoundationResponse::HTTP_FOUND);
        $client->followRedirect();

        $actuality2 = $entityManager->find(Actuality::class, 1);
        $this->assertEquals('UpdatedNamerrrrrrr', $actuality2->getName(), 'Le nom de l\'actualité n\'a pas été mis à jour correctement.');

    }

    public function testDeleteActuality(): void
    {
        $client = static::createClient();
        $urlGenerator = $client->getContainer()->get('router');
        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');

        $actuality = $entityManager->find(Actuality::class, 6);
        $crawler = $client->request(
            Request::METHOD_GET,
            $urlGenerator->generate('actuality.delete', ['id' => $actuality->getId()])
        );
        $deleteActuality = $entityManager->find(Actuality::class, 6);
        $this->assertNull($deleteActuality, 'L\'actualité n\'a pas été supprimée correctement.');
    }
}
