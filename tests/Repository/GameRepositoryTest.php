<?php

namespace App\Tests\Repository;

use App\Entity\Game;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class GameRepositoryTest extends KernelTestCase
{

    public function testSaveGame()
    {
        self::bootKernel();
        $container = self::getContainer();

        $entityManager = $container->get(EntityManagerInterface::class);

        $game = new Game();
        $game->setName('Assassin\'s Creed')
            ->setDescription("Assasin's Creed is an action-adventure video game series")
            ->setScore(8)
            ->setReleaseDate(new DateTime(('2007-11-13')));

        $entityManager->getRepository(Game::class)->save($game, true);

        $this->assertIsInt($game->getId());

        $game = $entityManager->getRepository(Game::class, $game)->find($game->getId());

        $this->assertInstanceOf(Game::class, $game);
        $this->assertEquals('Assassin\'s Creed', $game->getName());
        $this->assertEquals('Assasin\'s Creed is an action-adventure video game series', $game->getDescription());
        $this->assertEquals(8, $game->getScore());

    }

}
