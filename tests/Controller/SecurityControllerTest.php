<?php

namespace App\Tests\Controller;

use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

final class SecurityControllerTest extends WebTestCase
{
    public function testLoginWithBadCredentials(){
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        $form = $crawler->selectButton('Se connecter')
            ->form([
                '_username' => 'wrong_username',
                '_password' => 'wrong_password',
            ]);
        $client->submit($form); 
        

        self::assertResponseRedirects('/login');
        $client->followRedirect();
        $this->assertSelectorExists('.alert.alert-danger');
    }

    public function testSuccessfullLogin(){
        

        $client = static::createClient();

        // $databaseTool = self::getContainer()->get(DatabaseToolCollection::class)->get();
    
        // $databaseTool->loadAliceFixture([
        // dirname(__DIR__).'/fixtures/User.yaml'
        // ]);

        
      
        // Premier possibilité

        $crawler = $client->request('GET', '/login');
        $form = $crawler->selectButton('Se connecter')
            ->form([
                '_username' => 'user0@domain.fr',
                '_password' => '0000',
            ]);
        $client->submit($form); 
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        self::assertResponseRedirects('/');


        // Deuxieme possibilité
    //     $client->request('POST', '/login', [
    //         '_username' => 'admin@admin.com',
    //         '_password' => '000000',
    //     ]);
   
    // self::assertResponseRedirects('/');
    // $client->followRedirect();
 
    }   

    public function testLoginSuccess(){
        $client = static::createClient();

        $urlGenerator = $client->getContainer()->get('router');
        $crawler = $client->request('GET', $urlGenerator->generate('app_login'));
        $this->assertResponseIsSuccessful();

        $form = $crawler->selectButton('Se connecter')->form(
            [
                '_username' => 'user1@test.com',
                '_password' => 'admin',
            ]
        );

        $client->submit($form);
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        $client->followRedirect();

        $this->assertRouteSame('app.fo.app_home');
       
    }

    public function testLogout(){
        $client = static::createClient();
        $client->request('GET', '/logout');
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        self::assertResponseRedirects('/login');
    }

    
}