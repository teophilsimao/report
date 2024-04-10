<?php

namespace App\Controller;

use App\Card\Card;
use App\Card\CardGraphic;
use App\Card\CardHand;
use App\Card\DeckOfCard;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class CardControllerJson extends AbstractController
{
    #[Route("/api/deck", name: "deck", methods: ['GET'])]
    public function jsonDeck(): Response
    {

        $deck = new DeckOfCard();
        $deck->createDeck();
        $cards = $deck->getString();

        $data = [
            "deck" => $cards
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route("/api/deck/shuffle", name: "deckshuffle", methods: ['POST'])]
    public function jsonDeckShuffle(
        SessionInterface $session
    ): Response {

        $deck = new DeckOfCard();
        $deck->createDeck();
        $shuffled = $deck -> getStringShuffled();

        $data = [
            "shuffled" => $shuffled
        ];

        $session->set('deck', $deck);

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route("/api/deck/draw", name: "deckdraw", methods: ['POST'])]
    public function jsonDeckDraw(SessionInterface $session): Response
    {

        $deck = $session->get('deck');

        if (!$deck) {
            return new JsonResponse(['error' => 'Deck not created yet'], 404);
        }

        $randcard = $deck->drawCard();
        $deckLength = $deck->getNumberOfCards();

        $data = [
            'randcard' => $randcard,
            'deckLenght' => $deckLength
        ];

        $session->set('deck', $deck);

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route("/api/deck/draw/{number<\d+>}", name: "deckdrawNumb", methods: ['POST'])]
    public function jsonDeckDrawNum(SessionInterface $session, Request $request): Response
    {

        $deck = $session->get('deck');

        if (!$deck) {
            return new JsonResponse(['error' => 'Deck not created yet'], 404);
        }
        $number = $request->attributes->get('number');

        $drawnCards = [];
        for ($i = 0; $i < $number; $i++) {
            $drawnCard = $deck->drawCard();
            if ($drawnCard !== null) {
                $drawnCards[] = $drawnCard;
            }
        }
        $deckLength = $deck->getNumberOfCards();

        $data = [
            'drawnCards' => $drawnCards,
            'deckLenght' => $deckLength
        ];

        $session->set('deck', $deck);

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

}
