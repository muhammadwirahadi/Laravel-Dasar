<?php

namespace Tests\Feature;

use App\Data\Bar;
use App\Data\Foo;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DependencyInjectionTest extends TestCase
{

    public function testDepedencyInjection()
    {
        // disarankan menggunkan ini (construct)
        $foo = new Foo();
        $bar = new Bar($foo);
       
        // menggunakan function   
        // $bar->setFoo($foo);

        // menggunakan atribut
        // $bar->foo = $foo;

        self::assertEquals('Foo and Bar', $bar->bar());
    }
}
