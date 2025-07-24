<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class GoogleMapController extends AbstractController
{
    #[Route('/googleMap', name: 'app_google_map')]
    public function index(Request $request): Response
    {   
         
        $data = json_decode($request->getContent(), true);
        error_log(print_r($data, true)); 
        $latitude = $data['latitude'] ?? null;
        $longitude = $data['longitude'] ?? null;
        // dd($latitude, $longitude);

    $origin = ""; 
    $destination = "BIANCO,+Antananarivo";

    $googleMapsUrl = sprintf(
        'https://www.google.com/maps/dir/?api=1&origin=%s&destination=%s&travelmode=driving&dir_action=navigate',
        urlencode($origin),
        urlencode($destination)
    );

    return $this->render('google_map/index.html.twig', [
        'googleMapsUrl' => $googleMapsUrl  
    ]);
}
}
