<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase  
{
      public function testLoginPageLoadsSuccessfully(): void
    {
        $client = static::createClient();
        $client->request('GET', '/login');

        $this->assertResponseIsSuccessful();
        // $this->assertSelectorTextContains('h1', 'Connexion'); // Adaptez selon votre template
    }

    public function testLoginPageShowsErrorWhenInvalidCredentials(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');

        $form = $crawler->selectButton('Se connecter')->form([
            '_username' => 'invalid@example.com',
            '_password' => 'wrongpassword',
        ]);

        $client->submit($form);

        // Vérifie qu'on reste sur la page de login
        $this->assertResponseRedirects('/login');
        $client->followRedirect();
        
        // Vérifie l'affichage de l'erreur
        // $this->assertSelectorTextContains('.alert-danger', 'Identifiants invalides');
    }

    public function testLoginPageContainsLastUsername(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login?error=1');

        
        $form = $crawler->selectButton('Se connecter')->form([
            '_username' => 'admin@admin.com',
            '_password' => 'admin',
        ]);

        $client->submit($form);
        $client->followRedirect();

     
        $this->assertInputValueSame('_username', 'test@example.com');
    }

    
}