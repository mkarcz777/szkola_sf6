<?php

namespace App\Service;

use Symfony\Component\Filesystem\Filesystem;

class CodeGenerator
{
//    public Filesystem $filesystem; // niepotrzebne w PHP 8
//    private string $codePrefix;

    /**
     * @param Filesystem $filesystem
     * @param CodeCreator $creator
     * @param string $codePrefix
     */
    public function __construct(
        public Filesystem $filesystem,
        public CodeCreator $creator,
        private readonly string $codePrefix
    ) {
//        $this->filesystem = $filesystem; //niepotrzebne w PHP 8 - wlasciwosci ustawione sa automatycznie na podstawie
//                                          argumentow konstruktora; wystarczy dodac operatory public itp.
//        $this->codePrefix = $codePrefix;
    }

    public function generate(): string
    {
        $code = $this->creator->createCode($this->codePrefix);
        $this->filesystem->mkdir('codes');
        $this->filesystem->touch('codes/'.$code.'.txt');
        file_put_contents('codes/'.$code.'.txt',$code);

        return $code;
    }
}