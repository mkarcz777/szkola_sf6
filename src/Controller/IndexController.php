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
        return new Response(content: '<h2>Hello World!</h2>');
    }
    #[Route('/about', name: 'index.about')]
    public function about(): Response
    {
        return new Response(content: '<h2>About page</h2>');
    }
    #[Route('/hello/{firstName}', name: 'index.hello', methods: ['GET'])]
    public function hello(string $firstName = 'anonymous'): Response
    {
        return new Response(content: '<h2>Hello, '.$firstName.'!</h2>');
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