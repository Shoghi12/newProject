<?php

namespace App\tests\page;

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

        //    $this->assertSelectorTextContains('body', 'Votre message a été envoyé avec succès');

        // $this->assertSelectorTextContains('h2', 'CONTACT US');
        // $form[];
        $this->assertEquals(1, count($submitButton));
    }
  
    
}
