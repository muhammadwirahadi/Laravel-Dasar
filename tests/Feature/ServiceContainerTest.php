<?php

namespace Tests\Feature;

use App\Data\Foo;
use App\Data\Bar;
use App\Data\Person;
use App\Services;
use App\Services\HelloService;
use App\Services\HelloServiceIndonesia;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ServiceContainerTest extends TestCase
{
    public function testDepedency()
    {
        // $foo = new Foo();
        $foo = $this->app->make(Foo::class); // seaakan2 seperti new Foo() 
        $foo2 = $this->app->make(Foo::class); // sama ini juga seaakan2 seperti new Foo() 

        self::assertEquals('Foo', $foo->foo());
        self::assertEquals('Foo', $foo2->foo());
        self::assertNotSame($foo, $foo2);
    }

    public function testBind()
    {
        // $person = $this->app->make(Person::class); // new Person()
        // self::assertNotNull($person);

        $this->app->bind(Person::class, function ($app) {
            return new Person('Muhammad', 'Wira Hadi');
        });

        $person1 = $this->app->make(Person::class); // closure() // new Person("Muhammad", "Wira Hadi")
        $person2 = $this->app->make(Person::class); // closure() // new Person("Muhammad", "Wira Hadi")

        self::assertEquals("Muhammad", $person1->firstName);
        self::assertEquals("Muhammad", $person2->firstName);
        self::assertNotSame($person1, $person2);
    }

    public function testSingleton()
    {

        // Perbedaan Bind dan Singleton adalah, kalau bind adalah Person() baru secara terus menerus
        // Sedangkan Singleton dibuat hanya 1 kali saja dan jika sudah ada akan di pake person yang sudah ada

        $this->app->singleton(Person::class, function ($app) {
            return new Person('Muhammad', 'Wira Hadi'); // ini dibikin 1 kali saja
        });

        $person1 = $this->app->make(Person::class); // new Person("Muhammad", "Wira Hadi") if not exists
        $person2 = $this->app->make(Person::class); // return existing

        self::assertEquals("Muhammad", $person1->firstName);
        self::assertEquals("Muhammad", $person2->firstName);
        self::assertSame($person1, $person2);
    }

    public function testInstance()
    {
        $person = new Person("Muhammad", "Wira Hadi");

        $this->app->instance(Person::class, $person);

        $person1 = $this->app->make(Person::class); // Objeknya $person
        $person2 = $this->app->make(Person::class); // Objeknya $person
        $person3 = $this->app->make(Person::class); // Objeknya $person

        self::assertEquals("Muhammad", $person1->firstName);
        self::assertEquals("Muhammad", $person2->firstName);
        self::assertEquals("Muhammad", $person3->firstName);
        self::assertSame($person1, $person2);
    }

    public function testDepedencyInjection()
    {
        $this->app->singleton(Foo::class, function ($app){
            return new Foo();
        });

        // agar membuat objek yang sudah ada digunakan disini jadi tidak perlu membuat objek baru
        $this->app->singleton(Bar::class, function ($app){
            $foo = $app->make(Foo::class);
            return new Bar($foo);
        });

        $foo = $this->app->make(Foo::class);
        $bar = $this->app->make(Bar::class);
        $bar2 = $this->app->make(Bar::class);

        self::assertSame($foo, $bar->foo);
        self::assertSame($bar, $bar2);

    }

    public function testInterfaceToClass() {
        
        $this->app->singleton(HelloService::class, HelloServiceIndonesia::class);

        $helloService = $this->app->make(HelloService::class);

        self::assertEquals("Hello Wira", $helloService->hello("Wira"));
    }
}
