<?php

namespace App\Controller;

use App\Service\StripeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PaymentController extends AbstractController
{
    #[Route('/pay', name: 'pay')]
    public function pay(StripeService $stripeService): Response
    {
        // Par exemple, 10€ = 1000 centimes
        $paymentIntent = $stripeService->createPaymentIntent(1000);

        return $this->json([
            'clientSecret' => $paymentIntent->client_secret,
        ]);
    }
}
