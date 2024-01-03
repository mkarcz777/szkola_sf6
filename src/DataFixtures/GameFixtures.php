<?php

namespace App\DataFixtures;

use App\Entity\Game;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class GameFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        for ($i = 0; $i < 20; $i++)
        {
            $game = new Game();
            $game->setName('Game '.$i)
                ->setDescription('Lorem impsum description '.$i)
                ->setReleaseDate(new \DateTime())
                ->setScore(random_int(1,10));

            $manager->persist($game);
        }

        $manager->flush();
    }
}
