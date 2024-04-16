<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ControllerJson extends AbstractController
{
    #[Route("/api", name: "api")]
    public function api(): Response
    {
        $routes = [
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
            [
                'route' => $this->generateUrl('card_home'),
                'description' => 'Home page with info and picture about the card',
            ],
            [
                'route' => $this->generateUrl('deck'),
                'description' => 'Unshuffled deck of card',
            ],
            [
                'route' => $this->generateUrl('deck_shuffle'),
                'description' => 'shuffled deck',
            ],
            [
                'route' => $this->generateUrl('deck_draw'),
                'description' => 'A drawn card',
            ],
            [
                'route' => $this->generateUrl('cardform'),
                'description' => 'Buttons and form to ges a specific amount of card',
            ],
            [
                'route' => $this->generateUrl('cardform_post'),
                'description' => 'To post the given form information',
            ],
            [
                'route' => $this->generateUrl('deck_drawHand', ['number' => 3]),
                'description' => 'Draws a hand of card based on the amount given from the form',
            ],
            [
                'route' => $this->generateUrl('session_delete'),
                'description' => 'Deletes the session',
            ],
            [
                'route' => $this->generateUrl('session'),
                'description' => 'Shows the session',
            ],
            [
                'route' => $this->generateUrl('apiDeck'),
                'description' => 'Shows the deck in API',
            ],
            [
                'route' => $this->generateUrl('apiDeckShuffle'),
                'description' => 'Shows the deck shuffled in API',
            ],
            [
                'route' => $this->generateUrl('apiDeckDraw'),
                'description' => 'Draws a card in API',
            ],
            [
                'route' => $this->generateUrl('apiDeckDrawNumber', ['number' => 3]),
                'description' => 'Draws mutiples card in API',
            ],
        ];

        $response = new JsonResponse($routes);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
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


        $data = [
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
