<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    #[Route('/', name: 'index.home')]
    public function home(): Response
    {
        return $this->render(view: 'index/home.html.twig');
    }
    #[Route('/about', name: 'index.about')]
    public function about(): Response
    {
        return $this->render(view: 'index/about.html.twig');
    }
    #[Route('/hello/{firstName}', name: 'index.hello', methods: ['GET'])]
    public function hello(string $firstName = 'anonymous'): Response
    {
        $favGames = [
            'CS:GO',
            'WoW',
            'HoMM3'
        ];
        return $this->render(view: 'index/hello.html.twig',
            parameters: [
                'firstname' => $firstName,
                'favGames' => $favGames
            ]);
    }

    #[Route('/top', name: 'index.top')]
    public function top()
    {
        $topGames = [
            'CS:GO',
            'WoW'
        ];
        return new JsonResponse(data: $topGames);
    }

}