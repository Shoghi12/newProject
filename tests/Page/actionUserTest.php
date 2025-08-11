<?php

namespace App\Tests\Page;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class actionUserTest extends WebTestCase
{
    public function testUserCreateActuality(): void
    {
        $client = static::createClient();
        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');

        $user = $entityManager->getRepository(User::class)->findOneBy(['id' => 12]);

        $client->loginUser($user);

        $this->assertNotNull($client->getContainer()->get('security.token_storage')->getToken()->getUser());
        
        $crawler =$client->request(Request::METHOD_GET, 'actuality/new');
        $this->assertResponseIsSuccessful();

        $submitButton = $crawler->selectButton('Envoyer'); 
        $form = $submitButton->form();

        $form["actuality[name]"] = "MonFormulaireUser";
        $form["actuality[description]"] = "UpdatedDescription";
        $form["actuality[content]"] = "UpdatedContent";
        $form["actuality[status]"] = true;

        $client->submit($form);

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        $client->followRedirect();

        $this->assertRouteSame('app.fo.app_home');

        



    }
}
