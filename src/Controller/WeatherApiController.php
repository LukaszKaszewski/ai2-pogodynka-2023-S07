<?php

namespace App\Controller;

use App\Entity\Measurement;
use App\Service\WeatherUtil;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;

class WeatherApiController extends AbstractController
{
    #[Route('/api/v1/weather', name: 'app_weather_api', methods: ['GET'])]
    public function index(
        WeatherUtil                            $util,
        #[MapQueryParameter('country')] string $country,
        #[MapQueryParameter('city')] string    $city,
        #[MapQueryParameter('format')] string  $format = 'json',
        #[MapQueryParameter('twig')] bool      $twig = false,
    ): Response
    {
        $measurements = $util->getWeatherForCountryAndCity($country, $city);

        if ($format === 'csv') {
            $csvData = array_map(fn(Measurement $m) => implode(',', [
                $city,
                $country,
                $m->getDate()->format('Y-m-d'),
                $m->getTemperature(),
                $m->getFahrehneit(),
            ]), $measurements);

            array_unshift($csvData, 'city,country,date,temperature,fahrenheits');
            $csvContent = implode("\n", $csvData);

            return new Response($csvContent, 200, [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="weather.csv"',
            ]);
        }

        if ($twig) {

            return $this->render('weather_api/index.json.twig', [
                'city' => $city,
                'country' => $country,
                'measurements' => $measurements,
            ]);
        } else {
            $data = array_map(fn(Measurement $m) => [
                'date' => $m->getDate()->format('Y-m-d'),
                'temperature' => $m->getTemperature(),
                'fahrenheit' => $m->getFahrehneit(),
            ], $measurements);

            return $this->json($data);
        }


    }
}
