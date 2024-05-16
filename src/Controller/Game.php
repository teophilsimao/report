<?php

namespace App\Controller;

use App\Card\CardPoint;
use App\Card\CardHand;
use App\Card\DeckDraw;
use App\Card\Player;
use App\Card\Game21;
use App\Card\GameFlash;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Game extends AbstractController
{
    #[Route("/game", name: "game21_home")]
    public function game21(SessionInterface $session): Response
    {
        if (!$session->has('player')) {
            $game21 = new Game21();

            $deck = $game21->getDeck();
            $session->set('deck', $deck);

            $player = $game21->getPlayer();
            $session->set('player', $player);
            $session->set('playerPoint', 0);
            $session->set('latestCardRank', '');

            $dealer = $game21->getDealer();
            $session->set('dealer', $dealer);
            $session->set('dealerPoint', 0);
        }

        return $this->render('game/home.html.twig');
    }

    #[Route("/game/play", name: "game21_play", methods: ['GET'])]
    public function game21Play(SessionInterface $session): Response
    {   /** @var Player $player */
        $player = $session->get('player');
        /** @var Player $dealer */
        $dealer = $session->get('dealer');
        $pPoint = $session->get('playerPoint');
        $dPoint = $session->get('dealerPoint');

        $pCards = $player->getString();
        $dCards = $dealer->getString();

        if ($pPoint > 21) {
            $session->set('showFlashMessage', true);
            $this->addFlash(
                'warning',
                'Du förlorade!'
            );
        }

        $data = [
            "pCards" => $pCards,
            "pPoints" => $pPoint,
            "latestCardRank" => $session->get('latestCardRank'),
            "dCards" => $dCards,
            "dPoints" => $dPoint,
            "showFlashMessage" => $session->get('showFlashMessage')
        ];

        return $this->render('game/play.html.twig', $data);
    }

    #[Route("/game/hit", name: "game21_hit", methods: ['POST'])]
    public function game21Hit(SessionInterface $session): Response
    {
        /** @var DeckDraw $deck */
        $deck = $session->get('deck');
        /** @var Player $player */
        $player = $session->get('player');

        $player->hit($deck);
        $cards = $player->getCards();
        $latestCard = end($cards);
        // @phpstan-ignore-next-line
        $latestCardRank = $latestCard->getRank();
        $session->set('latestCardRank', $latestCardRank);
        if ($latestCardRank === 'Ace') {
            return $this->redirectToRoute('game21_play');
        }

        $session->set('player', $player);
        $pPoint = $player->getScore();
        $session->set('playerPoint', $pPoint);

        return $this->redirectToRoute('game21_play');
    }

    #[Route("/game/aceform", name: "game21_aceform", methods: ['POST'])]
    public function game21AceForm(SessionInterface $session, Request $request): Response
    {
        $aceValue = $request->request->get('aceValue');
        /** @var Player $player */
        $player = $session->get('player');

        $cards = $player->getCards();
        $latestCard = end($cards);
        // @phpstan-ignore-next-line
        $latestCardRank = $latestCard->getRank();
        $session->set('latestCardRank', $latestCardRank);
        if ($latestCardRank === 'Ace') {
            // @phpstan-ignore-next-line
            $latestCard->setAceValue((int)$aceValue);
        }



        $session->set('player', $player);
        $pPoint = $player->getScore();
        $session->set('playerPoint', $pPoint);

        return $this->redirectToRoute('game21_play');
    }

    #[Route("/game/stand", name: "game21_stand", methods: ['POST'])]
    public function game21Stand(SessionInterface $session): Response
    {
        $deck = $session->get('deck');
        /** @var Player $dealer */
        $dealer = $session->get('dealer');
        $dPoint = $session->get('dealerPoint');
        $pPoint = $session->get('playerPoint');

        while ($dPoint < 17) {
            /** @var DeckDraw $deck */
            $dealer->hit($deck);
            $cards = $dealer->getCards();
            $latestCard = end($cards);
            // @phpstan-ignore-next-line
            $latestCardRank = $latestCard->getRank();
            if ($latestCardRank === 'Ace') {
                $aceValue = ($dPoint < 7) ? 14 : 1;
                // @phpstan-ignore-next-line
                $latestCard->setAceValue($aceValue);
            }
            $dPoint = $dealer->getScore();
        }

        $session->set('dealer', $dealer);
        $session->set('dealerPoint', $dPoint);

        $flash = new GameFlash();
        $flashMessage = $flash->setFlash($pPoint, $dPoint);
        $session->set('showFlashMessage', $flashMessage['showFlashMessage']);
        $flassArray = $flashMessage['flashMessage'];
        // @phpstan-ignore-next-line
        $this->addFlash($flassArray['type'], $flassArray['message']);


        return $this->redirectToRoute('game21_play');
    }

    #[Route("game/restart", name: "game21_restart", methods: ['POST'])]
    public function car21Restart(SessionInterface $session): Response
    {
        $session->clear();

        if (!$session->has('deck')) {
            $game21 = new Game21();

            $deck = $game21->getDeck();
            $session->set('deck', $deck);

            $session->set('playerPoint', 0);
            $session->set('dealerPoint', 0);
            $session->set('latestCardRank', '');


            $player = $game21->getPlayer();
            $session->set('player', $player);

            $dealer = $game21->getDealer();
            $session->set('dealer', $dealer);
        }

        return $this->redirectToRoute('game21_play');
    }

    #[Route("/game/doc", name: "game21_doc")]
    public function game21Doc(): Response
    {
        return $this->render('game/doc/game.html.twig');
    }
}
