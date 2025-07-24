<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

final class PageControllerTest extends WebTestCase
{
  public function testHelloPage(){
    $client = static::createClient();
    $client->request('GET', '/hello');
    
    self::assertResponseStatusCodeSame(Response::HTTP_OK);
 
  }

  public function testH1HelloPage(){
    $client = static::createClient();
    $client->request('GET', '/hello');
    
    self::assertSelectorTextContains('h1', 'Bienvenue sur mon site');
  }

  public function testAuthPageIsRestricted(){
    $client = static::createClient();
    $client->request('GET', '/auth');
    
    $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
  }

  public function testRedirectToLogin(){
    $client = static::createClient();
    $client->request('GET', '/auth');
    
    self::assertResponseRedirects('/login');
  }
}
