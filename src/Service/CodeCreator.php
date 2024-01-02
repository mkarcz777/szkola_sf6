<?php

namespace App\Service;

class CodeCreator
{
    public function createCode(string $prefix): string
    {
        return $prefix . '-' . random_int(1000, 9000);
    }
}