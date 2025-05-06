<?php

namespace App;

class HelloWorld
{
    public function sayHello(string $name, ?string $lastname = null): string
    {
        $stringLastname = '';
        if ($lastname !== null) {
            $stringLastname = ' '.$lastname;
        }

        return 'Bonjour '.$name.$stringLastname;
    }

    public function sayGoodbye(string $name, ?string $lastname = null): string
    {
        return 'Aurevoir '.$name.($lastname !== null ? ' '.$lastname : '');
    }
}