<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LanguageControllerTest extends WebTestCase
{
    public function testIfLanguageControllerExist(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/language');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Hello LanguageController! ✅');
    }
}
