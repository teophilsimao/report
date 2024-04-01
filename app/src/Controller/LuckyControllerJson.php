<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class LuckyControllerJson extends AbstractController
{   
    #[Route("/api", name: "api")]
    public function api(): Response
    {
        $jsonRoutes = [
            [
                'route' => $this->generateUrl('home'),
                'description' => 'Home',
            ],
            [
                'route' => $this->generateUrl('about'),
                'description' => 'About the course',
            ],
            [
                'route' => $this->generateUrl('report'),
                'description' => 'report for kmom',
            ],
            [
                'route' => $this->generateUrl('lucky'),
                'description' => 'random picture and random number',
            ],
            [
                'route' => $this->generateUrl('api'),
                'description' => 'routes',
            ],
            [
                'route' => $this->generateUrl('quote'),
                'description' => 'random daily quoute',
            ],
        ];

        return $this->render('api.html.twig', [
            'jsonRoutes' => $jsonRoutes,
        ]);
    }

    #[Route("/api/quote", name: "quote")]
    public function jsonQuote(): Response
    {

        $quotes = [
           "Do one thing every day that scares you.",
           "If you cannot do great things, do small things in a great way.",
           "Always do your best. What you plant now, you will harvest later."
        ];

        $index = array_rand($quotes);
        $quote = $quotes[$index];

        $date = date('Y-m-d');
        $time = date('H:i:s', time());
        

        $data =[
            'quote' => $quote,
            'date' => $date,
            'time' => $time
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

}
