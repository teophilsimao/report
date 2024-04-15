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
use Symfony\Component\Routing\Annotation\Route;

class CardGame extends AbstractController
{
    // test part
    #[Route("/card/test/card", name: "one_card")]
    public function oneCard(): Response
    {
        $card = new Card();
        $card->drawCard();

        $data = [
            "card" => $card->getAsString()
        ];

        return $this->render('card/test/card.html.twig', $data);
    }

    #[Route("/card/test/hand/{number<\d+>}", name: "card_hand")]
    public function cardHand(int $number): Response
    {

        $hand = new CardHand();
        for ($i = 0; $i < $number; $i++) {
            if ($i % 2 === 1) {
                $hand->add(new Card());
            } else {
                $hand->add(new CardGraphic());
            }
        }

        $hand->drawCard();

        $data = [
            "hand" => $hand->getString()
        ];

        return $this->render('card/test/cards.html.twig', $data);
    }

    #[Route("/card/test/deck", name: "deck")]
    public function deck(): Response
    {
        $deck = new DeckOfCard();
        $deck->add(new CardGraphic());
        $deck->createDeck();

        $data = [
            "deck" => $deck->getString()
        ];

        return $this->render('card/test/deck.html.twig', $data);
    }

    #[Route("/card/test/shuffle", name: "shuffle")]
    public function deckshuffle(): Response
    {
        $deck = new DeckOfCard();
        $deck->add(new CardGraphic());
        $deck->createDeck();
        $deck->shuffle();

        $data = [
            "deck" => $deck->getString()
        ];

        return $this->render('card/test/shuffle.html.twig', $data);
    }
}