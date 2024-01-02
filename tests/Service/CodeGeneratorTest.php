<?php

namespace App\Tests\Service;

use App\Service\CodeCreator;
use App\Service\CodeGenerator;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Filesystem\Filesystem;

class CodeGeneratorTest extends KernelTestCase
{
    public function testCreateCode() //test jednostkowy
    {
        $codeCreator = new CodeCreator();
        $code = $codeCreator->createCode('test');

        $this->assertIsString($code);
        $this->assertEquals(9, strlen($code));
    }

    public function testGenerateCode() //test integracyjny
    {

        self::bootKernel();
        $container = static::getContainer();

        $fileSystem = $container->get(Filesystem::class);
        $codeCreator = $container->get(CodeCreator::class);

        $codeGenerator = new CodeGenerator(
            $fileSystem,
            $codeCreator,
            'ABC'
        );

        $code = $codeGenerator->generate();

        $this->assertIsString($code);
        $this->assertMatchesRegularExpression('/[A-Z]{3}-[0-9]{4}/', $code);
    }
}
