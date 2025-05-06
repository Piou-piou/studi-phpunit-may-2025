<?php

namespace Tests;

use App\HelloWorld;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class HelloWorldTest extends TestCase
{
    public static function sayHelloProvider(): array
    {
        return [
            ['Wilfried', null, 'Wilfried'],
            ['Wilfried', 'Nomdefamille', 'Wilfried Nomdefamille'],
            ['Bruno', 'Nomdefamille', 'Bruno Nomdefamille'],
        ];
    }

    #[DataProvider('sayHelloProvider')]
    public function testSayHello(string $name, ?string $lastname, string $returnString)
    {
        $returnString = 'Bonjour '.$returnString;
        $helloWorld = new HelloWorld();
        $sayHello = $helloWorld->sayHello($name, $lastname);

        $this->assertSame($returnString, $sayHello);
    }

    #[DataProvider('sayHelloProvider')]
    public function testSayGoodbye(string $name, ?string $lastname, string $returnString)
    {
        $returnString = 'Aurevoir '.$returnString;
        $helloWorld = new HelloWorld();
        $sayGoodbye = $helloWorld->sayGoodbye($name, $lastname);

        $this->assertSame($returnString, $sayGoodbye);
    }
}