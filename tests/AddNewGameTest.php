<?php

namespace App\Tests;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AddNewGameTest extends WebTestCase
{
    public function testSomething(): void
    {

        $client = static::createClient();

        //------------- wlasciwe kroki do testowania uwierzytelnienia

        $userRepository = static::getContainer()->get(UserRepository::class);

        //retrieve test user
        $testUser = $userRepository->findOneBy(['email' => 'it03@skassa.pl']);

        //simulate $tesUser being logged in
        $client->loginUser($testUser);


        //---------------------


        $crawler = $client->request('GET', '/game/new');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h3', 'Add a new game');
    }
}
