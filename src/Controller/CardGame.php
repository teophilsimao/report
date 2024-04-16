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
    //Home, starts session
    #[Route("/card", name:"card_home")]
    public function home(SessionInterface $session): Response
    {
        if (!$session->isStarted()) {
            $session->start();
        }

        $deck = new DeckOfCard();
        $deck->add(new CardGraphic());
        $deck->createDeck();
        $session->set('deck', $deck);

        return $this->render('card/home.html.twig');
    }

    //Deck
    #[Route("/card/deck", name: "deck", methods: ['GET'])]
    public function cardDeck(
        Request $request,
        SessionInterface $session
    ): Response
    {
        $deck = $session->get('deck');
        $deckStr = $deck->getString();
        $deckAmount = $deck->getAmount();

        $data = [
            "deckStr" => $deckStr,
            "deckAmount" => $deckAmount
        ];

        return $this->render('card/deck.html.twig', $data);

    }

    //Shuffle Deck
    #[Route("/card/deck/shuffle", name: "deck_shuffle", methods: ['GET'])]
    public function ShuffledDeck(
        SessionInterface $session
    ): Response
    {
        $deck = new DeckOfCard();
        $deck->add(new CardGraphic());
        $deck->createDeck();
        $session->set('deck', $deck);

        $deck = $session->get('deck');
        $deck->shuffle();
        $deckAmount = $deck->getAmount();

        $data = [
            "deck" => $deck->getString(),
            "deckAmount" => $deckAmount
        ];

        return $this->render('card/deckshuffle.html.twig', $data);

    }

    //Card Form
    #[Route("/card/cardform", name: "cardform", methods: ['GET'])]
    public function cardForm(
        SessionInterface $session
    ): Response
    {
        $deck = $session->get('deck');
        $deckAmount = $deck->getAmount();

        $data = [
            "deckAmount" => $deckAmount
        ];

        return $this->render('card/cardform.html.twig', $data);

    }

    //Delete, clears and starts session
    #[Route("/session/delete", name:"session_delete")]
    public function sessionDelete(SessionInterface $session): Response
    {   
        $session->clear();

        if (!$session->isStarted()) {
            $session->start();
        }

        return $this->redirectToRoute('card_home');
    }



    // TESTS
    #[Route("/card/test/card", name: "one_card_test")]
    public function oneCardTest(): Response
    {
        $card = new Card();
        $card->drawCard();

        $data = [
            "card" => $card->getAsString()
        ];

        return $this->render('card/test/card.html.twig', $data);
    }

    #[Route("/card/test/hand/{number<\d+>}", name: "card_hand_test")]
    public function cardHandTest(int $number): Response
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

    #[Route("/card/test/deck", name: "deck_test")]
    public function deckTest(): Response
    {
        $deck = new DeckOfCard();
        $deck->add(new CardGraphic());
        $deck->createDeck();

        $data = [
            "deck" => $deck->getString()
        ];

        return $this->render('card/test/deck.html.twig', $data);
    }

    #[Route("/card/test/shuffle", name: "shuffle_test")]
    public function deckshuffleTest(): Response
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