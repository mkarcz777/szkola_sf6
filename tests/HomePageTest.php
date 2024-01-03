<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomePageTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        //symulacja klikniecia w link
        $link = $crawler->selectLink('O nas')->link();
        $client->click($link);

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('p', 'Boil mild margerines in an ice blender with ketchup for about an hour to soothe their viscosity.');

//        $this->assertResponseIsSuccessful();
//        $this->assertSelectorTextContains('h1', 'Hello World');
    }
}
