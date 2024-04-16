<?php

namespace App\Controller;

use App\Card\Card;
use App\Card\CardGraphic;
use App\Card\CardHand;
use App\Card\DeckOfCard;

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
        $deck->add(new CardGraphic());
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
        $deck->add(new CardGraphic());
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
    public function apiDeckDraw(SessionInterface $session, CardGraphic $card): Response
    {
        $deck = $session->get('deck');

        if (empty($deck->getDeck())) {
            return $this->render('card/draw.html.twig', [
                "card" => null,
                "deck" => null
            ]);
        }

        $drawnCard = null;

        do {
            $card->drawCard();
            $drawnCardStr = $card->getAsString();

            $cardInDeck = false;
            foreach ($deck->getDeck() as $key => $deckCard) {
                if ($deckCard->getAsString() === $drawnCardStr) {
                    $cardInDeck = true;
                    $drawnCard = $deckCard;
                    $deckArray = $session->get('deck')->getDeck();
                    unset($deckArray[$key]);
                    $session->get('deck')->setDeck(array_values($deckArray));
                    break;
                }
            }

            if ($cardInDeck) {
                break;
            }

        } while (true);

        $deckLength = $deck->getAmount();

        $data = [
            "card" => $drawnCard->getAsString(),
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
        $hand = new CardHand();
        $handStr = [];

        if (empty($deck->getDeck())) {
            return $this->render('card/drawhand.html.twig', [
                "hand" => null,
                "deck" => null
            ]);
        }

        for ($i = 0; $i < $number; $i++) {
            do {
                $hand->add(new CardGraphic());
                $hand->drawCard();
                $cardStr = $hand->getString()[0];

                $cardInDeck = false;
                foreach ($deck->getDeck() as $key => $deckCard) {
                    if ($deckCard->getAsString() === $cardStr) {
                        $cardInDeck = true;
                        break;
                    }
                }

                if ($cardInDeck && !in_array($cardStr, $handStr)) {
                    $handStr[] = $cardStr;
                    foreach ($deck->getDeck() as $key => $deckCard) {
                        if ($deckCard->getAsString() === $cardStr) {
                            $deckArray = $session->get('deck')->getDeck();
                            unset($deckArray[$key]);
                            $session->get('deck')->setDeck(array_values($deckArray));
                            break;
                        }
                    }
                    break;
                }
            } while (true);
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
