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
        if (!$session->has('deck')) {
            $deck = new DeckOfCard();
            $deck->add(new CardGraphic());
            $deck->createDeck();
            $session->set('deck', $deck);
        }

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
        $deck = $deck->getString();

        $data = [
            "deck" => $deck
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

        $data = [
            "deck" => $deck->getString()
        ];

        return $this->render('card/deckshuffle.html.twig', $data);

    }



    //Deck Draw one card
    #[Route("/card/deck/draw", name: "deck_draw", methods: ['GET'])]
    public function cardDraw(
        SessionInterface $session,
        CardGraphic $card
    ): Response
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
    
            $cardExistsInDeck = false;
            foreach ($deck->getDeck() as $key => $deckCard) {
                if ($deckCard->getAsString() === $drawnCardStr) {
                    $cardExistsInDeck = true;
                    $drawnCard = $deckCard;
                    $deckArray = $session->get('deck')->getDeck();
                    unset($deckArray[$key]);
                    $session->get('deck')->setDeck(array_values($deckArray));
                    break;
                }
            }
    
            if ($cardExistsInDeck) {
                break;
            }
    
        } while (true);

        $data = [
            "card" => $drawnCard->getAsString(),
            "deck" => $deck->getString()
        ];

        return $this->render('card/draw.html.twig', $data);

    }


    
    //Card Form
    #[Route("/card/cardform", name: "cardform", methods: ['GET'])]
    public function cardForm(
        SessionInterface $session
    ): Response
    {
        $deck = $session->get('deck');

        $data = [
            "deck" => $deck->getString()
        ];

        return $this->render('card/cardform.html.twig', $data);
    }



    //Cardform Post
    #[Route("/card/cardform", name: "cardform_post", methods: ['POST'])]
    public function cardFormPost(
        Request $request,
        SessionInterface $session
    ): Response
    {
        $number = $request->request->get('cards');
        $session->set("number", $number);

        return $this->redirectToRoute('deck_drawHand', ['number' => $number]);
    }

    //Deck Draw a hand
    #[Route("/card/deck/draw/{number<\d+>}", name: "deck_drawHand", methods: ['GET'])]
    public function cardDrawHand(
        SessionInterface $session
    ): Response
    {
        $deck = $session->get('deck');
        $number = $session->get('number');
        $hand = new CardHand;
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
    
                $cardExistsInDeck = false;
                foreach ($deck->getDeck() as $key => $deckCard) {
                    if ($deckCard->getAsString() === $cardStr) {
                        $cardExistsInDeck = true;
                        break;
                    }
                }
    
                if ($cardExistsInDeck && !in_array($cardStr, $handStr)) {
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
    

        $data = [
            "hand" => $handStr,
            "deck" => $deck->getString()
        ];

        return $this->render('card/drawhand.html.twig', $data);
    }

    //Delete, clears and starts session
    #[Route("/session/delete", name:"session_delete")]
    public function sessionDelete(SessionInterface $session): Response
    {   
        $session->clear();

        $this->addFlash(
            'notice',
            'nu är sessionen raderad'
        );

        return $this->redirectToRoute('home');
    }

    #[Route("/session", name:"session")]
    public function dumpSession(SessionInterface $session): Response
    {
        $sessionData = $session->all();

        return $this->render('session.html.twig', [
            'sessionData' => $sessionData
        ]);
    }
}