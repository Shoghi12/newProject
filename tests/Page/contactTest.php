<?php

namespace App\tests\Page;

use App\Entity\Contact;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class contactTest extends WebTestCase
{
    public function testIfCreateIngredientIsSuccessfull(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/contact');
        $urlGenerator = $client->getContainer()->get('router');
        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');

        $user = $entityManager->find(User::class, 1);  

        $client->loginUser($user);

        $crawler = $client->request(Request::METHOD_GET, $urlGenerator->generate('app_formulaire'));

        $form = $crawler->selectButton('SEND')->form();
        $form['contact[name]'] = 'myLastName';
        $form['contact[email]'] = 'myEmail@gmail.com';
        $form['contact[phone]'] = '12345677';
        $client->submit($form);

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        $client->followRedirect();
        $this->assertRouteSame('app.fo.app_home');
        // $this->assertResponseIsSuccessful();
        // $this->assertSelectorTextContains('h1', 'Hello World');
    }
    public function testIftest(): void
    {
     
    }
    
}
