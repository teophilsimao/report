<?php

namespace App\Controller;

use App\Card\Card;
use App\Card\CardGraphic;
use App\Card\CardHand;
use App\Card\DeckOfCard;
use App\Card\CardPoint;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CardGameJson extends AbstractController
{
    #[Route("/api/deck", name: "apiDeck", methods: ['GET'])]
    public function apiDeck(): Response
    {
        $deck = new DeckOfCard();
        $deck->add(new CardPoint());
        $deck->createDeck();
        $deckStr = $deck->getString();

        $data = [
            "deck" => $deckStr
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route("/api/deck/shuffle", name: "apiDeckShuffle", methods: ['POST'])]
    public function apiDeckShuffle(SessionInterface $session): Response
    {
        $deck = new DeckOfCard();
        $deck->add(new CardPoint());
        $deck->createDeck();
        $deck->shuffle();
        $deckStr = $deck->getString();
        $deckLength = $deck->getAmount();

        $data = [
            "deck" => $deckStr,
            "amount" => $deckLength
        ];

        $session->set('deck', $deck);

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route("/api/deck/draw", name: "apiDeckDraw", methods: ['POST'])]
    public function apiDeckDraw(SessionInterface $session): Response
    {
        $deck = $session->get('deck');

        if (!$deck instanceof DeckOfCard) {
            return new JsonResponse([
                'error' => 'Deck is not initialized'
            ], Response::HTTP_BAD_REQUEST);
        }

        $drawnCard = $deck->drawnCard();
        $drawnStr = $drawnCard ? $drawnCard->getAsString() : null;

        $session->set('deck', $deck);

        $deckLength = $deck->getAmount();

        $data = [
            "card" => $drawnStr,
            "amount" => $deckLength
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route("/api/deck/draw/{number<\d+>}", name: "apiDeckDrawNumber", methods: ['POST'])]
    public function apiDeckDrawNumber(SessionInterface $session, Request $request): Response
    {
        $deck = $session->get('deck');
        $number = $request->attributes->get('number');
        $handStr = [];

        if (!$deck instanceof DeckOfCard) {
            return new JsonResponse([
                'error' => 'Deck is not initialized'
            ], Response::HTTP_BAD_REQUEST);
        }


        for ($i = 0; $i < $number; $i++) {
            $drawnCardStr = $deck->drawnCards(new CardHand());

            if ($drawnCardStr !== null) {
                $handStr[] = $drawnCardStr;
            }
        }
        
        $deckLength = $deck->getAmount();

        $data = [
            "hand" => $handStr,
            "amount" => $deckLength
        ];



        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }
}
