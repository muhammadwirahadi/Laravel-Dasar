<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InputControllerTest extends TestCase
{

    public function testInput()
    {
        // get
        $this->get('/input/hello?name=Wira')
            ->assertSeeText("Hello Wira");

        // post
        $this->post('/input/hello', [
            'name' => 'Wira'
        ])->assertSeeText("Hello Wira");
    }

    public function testInputNested()
    {
        $this->post('/input/hello/first', [
            "name" => [
                "first" => "Wira",
                "last" => "Hadi",
            ]
        ])->assertSeeText("Hello Wira");
    }

    public function testInputAll()
    {
        $this->post('/input/hello/input', [
            "name" => [
                "first" => "Wira",
                "last" => "Hadi",
            ]
        ])->assertSeeText("name")
            ->assertSeeText("first")
            ->assertSeeText("last")
            ->assertSeeText("Wira")
            ->assertSeeText("Hadi");
    }

    public function testInputArray()
    {
        $this->post('/input/hello/array', [
            "products" => [
                [
                    "name" => "Apple Mac Book Pro",
                    "price" => 30000000,
                ],
                [
                    "name" => "Asus ROG",
                    "price" => 25000000,
                ]
            ]
        ])->assertSeeText("Apple Mac Book Pro")
            ->assertSeeText("Asus ROG");
    }

    public function testInputType()
    {
        $this->post('/input/type', [
            'name' => 'Riyan',
            'married' => 'true',
            'birth_date' => '2025-10-10'
        ])->assertSeeText('Riyan')
            ->assertSeeText('true')
            ->assertSeeText('2025-10-10');
    }

    public function testFilterOnly()
    {
        $this->post('/input/filter/only', [
            "name" => [
                "first" => "Muhammad",
                "middle" => "Wira",
                "last" => "Hadi"
            ]
        ])->assertSeeText('Muhammad')
            ->assertSeeText('Hadi')
            ->assertDontSeeText('Wira');
    }

    public function testFilterExcept()
    {
        $this->post('/input/filter/except', [
            'username' => 'wira',
            'admin' => 'true',
            'password' => 'rahasia'
        ])->assertSeeText('wira')
            ->assertSeeText('rahasia')
            ->assertDontSeeText('admin');
    }

    public function testFilterMerge()
    {
        $this->post('/input/filter/merge', [
            'username' => 'wira',
            'admin' => 'true',
            'password' => 'rahasia'
        ])->assertSeeText('wira')
            ->assertSeeText('rahasia')
            ->assertSeeText('admin')
            ->assertSeeText('false');
    }
}
