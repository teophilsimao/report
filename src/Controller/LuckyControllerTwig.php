<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LuckyControllerTwig extends AbstractController
{
    #[Route("/", name: "home")]
    public function home(): Response
    {
        return $this->render('home.html.twig');
    }

    #[Route("/about", name: "about")]
    public function about(): Response
    {
        return $this->render('about.html.twig');
    }

    #[Route("/report", name: "report")]
    public function report(): Response
    {
        return $this->render('report.html.twig');
    }

    #[Route("/lucky", name: "lucky")]
    public function lucky(): Response
    {
        $luckyNum = random_int(1, 100);

        $images = [
            '1.jpeg',
            '2.jpg',
            '6.jpg',
            '7.jpg',
            '8.jpg',
        ];

        $randimg = $images[array_rand($images)];

        return $this->render('lucky.html.twig', [
            'lucky_number' => $luckyNum,
            'image' => $randimg,
        ]);
    }
}
