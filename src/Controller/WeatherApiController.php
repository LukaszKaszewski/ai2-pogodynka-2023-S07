<?php

namespace App\Controller;

use App\Entity\Measurement;
use App\Service\WeatherUtil;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;

class WeatherApiController extends AbstractController
{
    #[Route('/api/v1/weather', name: 'app_weather_api', methods: ['GET'])]
    public function index(
        WeatherUtil                            $util,
        #[MapQueryParameter('country')] string $country,
        #[MapQueryParameter('city')] string    $city,
    ): JsonResponse
    {
        $measurements = $util->getWeatherForCountryAndCity($country, $city);

        $data = array_map(fn(Measurement $m) => [
            'date' => $m->getDate()->format('Y-m-d'),
            'temperature' => $m->getTemperature(),
        ], $measurements);

        return $this->json($data);
//        return $this->json([
//            'city' => $city,
//            'country' => $country,
//        ]);
    }
}
