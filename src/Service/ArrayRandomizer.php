<?php

namespace App\Service;

class ArrayRandomizer
{
    public function getRandomElements(array $someArray, int $numberOfElements = 5): array
    {
        $rkeys = array_rand($someArray, $numberOfElements);
        $outputArray = [];
        foreach ($rkeys as $key)
        {
            $outputArray[] = $someArray[$key];
        }

        return $outputArray;
    }
}