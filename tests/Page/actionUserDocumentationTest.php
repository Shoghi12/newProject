<?php

namespace App\Tests\Page;

use App\Entity\Documentation;
use App\Entity\User;
use PhpParser\Builder\Method;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class actionUserDocumentationTest extends WebTestCase
{
    public function testCreateAndUpdate(): void
    {
        $client = static::createClient();
        
        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');

        $user = $entityManager->getRepository(User::class)->find(13);

        $client->LoginUser($user);

        $this->assertNotNull($client->getContainer()->get('security.token_storage')->getToken()->getUser());
    
        $crawler = $client->request(Request::METHOD_GET, '/documentation/new');   
        $this->assertResponseIsSuccessful();

        $this->assertSelectorTextContains('h2', 'ADD DOCUMENTATION');

        $submitButton = $crawler->selectButton('Envoyer');
        $form = $submitButton->form();

        $form["documentation[name]"] = "MonDocumentationUser";
        $form["documentation[description]"] = "UpdatedDocumentationDescription";
        $form["documentation[status]"] = true;

        $client->submit($form);

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        $client->followRedirect();

        $this->assertRouteSame('app.fo.app_home');
    }

    public function testDocumentationEdit(): void
    {
        $client = static::createClient();
        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');

        $user = $entityManager->getRepository(User::class)->find(13);

        $client->LoginUser($user);

        $this->assertNotNull($client->getContainer()->get('security.token_storage')->getToken()->getUser());

        $documentation = $entityManager->find(Documentation::class, 37);
        $crawler = $client->request(Request::METHOD_GET, '/documentation/edit/' . $documentation->getId());

        $this->assertResponseIsSuccessful();

        $submitButton = $crawler->selectButton('Envoyer');
        $form = $submitButton->form();

        $form["documentation[name]"] = "UpdatedDocumentationName";

        $client->submit($form);

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        $client->followRedirect();

        $this->assertRouteSame('app.fo.app_home');

        $crawler2 = $client->request(Request::METHOD_GET, '/logout'); //logout user after test (only if you have logout);
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        $client->followRedirect();

        $this->assertRouteSame('app_login');
    }

    public function testDocumentationDelete(): void
    {
        $client = static::createClient();
        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');

        $user = $entityManager->getRepository(User::class)->find(13);

        $client->LoginUser($user);

        $this->assertNotNull($client->getContainer()->get('security.token_storage')->getToken()->getUser());

        $documentation = $entityManager->find(Documentation::class, 38);
        $crawler = $client->request(Request::METHOD_GET, '/documentation/delete/' . $documentation->getId());

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        $client->followRedirect();

        $this->assertRouteSame('app.fo.app_home');
    }
}
