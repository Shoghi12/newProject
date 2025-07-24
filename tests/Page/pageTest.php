<?php

namespace App\tests\Page;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class pageTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        
        $this->assertResponseIsSuccessful();

        $button = $crawler->selectButton('Inscription');
        $this->assertEquals(1, count($button));

        $list = $crawler->filter('.list .name');
        $this->assertEquals(14, count($list));
        

        $this->assertSelectorTextContains('h1', 'sqdf fsdqf');
    }
   
    
}
