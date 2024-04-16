<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ControllerTwig extends AbstractController
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
    public function number(): Response
    {
        $number = random_int(0, 100);

        $images =
        [
            'cow.jpg',
            'cows.jpg',
            'deer.jpg',
            'pinguins.jpg',
            'pyramid.jpg'
        ];

        $randimg = $images[array_rand($images)];

        $data = [
            'number' => $number,
            'image' => $randimg
        ];

        return $this->render('lucky.html.twig', $data);
    }
}