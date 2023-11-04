<?php

namespace App\Controller;

use App\Entity\Location;
use App\Repository\MeasurementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WeatherController extends AbstractController
{
//    comment to end of file
    #[Route('/weather/{id}', name: 'app_weather', requirements: ['id' => '\d+'])]
    #[Route('/weather/{city}/{country?PL}', name: 'app_weather_city')]
//    public function city (int $id):Response
    public function city(Location $location, MeasurementRepository $repository): Response
    {
        $measurements = $repository->findByLocation($location);

        return $this->render('weather/city.html.twig', [
            'location' => $location,
            'measurements' => $measurements,
        ]);
    }

}
