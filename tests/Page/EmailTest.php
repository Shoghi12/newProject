<?php

namespace App\Tests\Page;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class EmailTest extends WebTestCase
{
    public function testSendEmailSecond()
    {
        $mailer = $this->createMock(\Symfony\Component\Mailer\MailerInterface::class);
        $mailer->expects($this->once())->method('send');
    
        $client = static::createClient();
        $client->getContainer()->set('mailer.mailer', $mailer);
    
        $client->request('GET', '/send-email');
        $this->assertResponseIsSuccessful();
    }
}
