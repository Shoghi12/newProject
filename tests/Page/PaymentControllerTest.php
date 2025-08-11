<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Service\StripeService;
use Stripe\PaymentIntent;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class PaymentControllerTest extends WebTestCase
{
    public function testPay()
    {
        $client = static::createClient();

        // On crée un faux StripeService
        $stripeServiceMock = $this->createMock(StripeService::class);

        // On dit au mock de retourner un objet avec une propriété client_secret
        $fakePaymentIntent = new \stdClass();
        $fakePaymentIntent->client_secret = 'fake_secret_123';

        $stripeServiceMock->method('createPaymentIntent')
            ->willReturn($fakePaymentIntent);

        // On remplace le vrai service par le faux dans le conteneur
        $client->getContainer()->set(StripeService::class, $stripeServiceMock);

        // On appelle la route
        $client->request('GET', '/pay');

        // On vérifie la réponse
        $this->assertResponseIsSuccessful();

        $responseData = json_decode($client->getResponse()->getContent(), true);

        $this->assertArrayHasKey('clientSecret', $responseData);
        $this->assertEquals('fake_secret_123', $responseData['clientSecret']);
    }

     public function testStripePayment()
    {
        \Stripe\Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);

      $paymentMethod = \Stripe\PaymentMethod::create([
    'type' => 'card',
    'card' => ['token' => 'tok_visa'],
]);

   $client = static::createClient();

   $urlGenerator = $client->getContainer()->get('router');
   $url = $urlGenerator->generate('app_home', [], UrlGeneratorInterface::ABSOLUTE_URL);
//    $this->assertEquals($url, '/');

// 2. Créer le PaymentIntent en utilisant ce PaymentMethod
$paymentIntent = \Stripe\PaymentIntent::create([
    'amount' => 1000,
    'currency' => 'eur',
    'payment_method' => $paymentMethod->id,
    'confirmation_method' => 'manual', // ou 'automatic'
    'confirm' => true,
    'return_url' => $url, // URL de retour après le paiement
]);

        // Simuler une carte de test Stripe
     
//       $paymentMethod  = \Stripe\Token::create([
//         'card' => [
//            'number' => '4242424242424242',  // numéro de la carte de test
//            'exp_month' => 12,
//            'exp_year' => 2024,
//            'cvc' => '123',
//          ],
// ]);

//         // Confirmer le paiement
//       $confirmedIntent = $paymentIntent->confirm([
//     'payment_method' => $paymentMethod->id,
// ]);

        // Vérifier que le paiement est réussi
        $this->assertEquals('succeeded', $paymentIntent->status, 'Le paiement n\'a pas été effectué avec succès.');
    }
}
