<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RoutingTest extends TestCase
{

    // Routes menggunkan unit test
    public function testGet()
    {
        $this->get('mwh')
            ->assertStatus(200)
            ->assertSeeText('Hallo, Muhammad Wira Hadi :)');
    }

    // Redirect menggunkan unit test
    public function testRedirect()
    {
        $this->get('/youtube')
            ->assertRedirect('/mwh');
    }

    // Fallback menggunakan unit test
    public function testFallback()
    {

        $this->get('/tidakada')
            ->assertSeeText('File not found 404');

        $this->get('/tidakadalagi')
            ->assertSeeText('File not found 404');
    }

    // Test Route Parameter
    public function testRouteParameter()
    {

        $this->get('/products/1')
            ->assertSeeText('Product 1');

        $this->get('/products/2')
            ->assertSeeText('Product 2');

        $this->get('/products/1/items/XXX')
            ->assertSeeText('Product 1, Item XXX');

        $this->get('/products/2/items/YYY')
            ->assertSeeText('Product 2, Item YYY');
    }

    // Test Route Parameter Regex
    public function testRouteParameterRegex()
    {
        // idnya harus number
        $this->get('/catagories/100')
            ->assertSeeText('Catagory 100');

        // $this->get('/products/wira') ------> akan error kalo bukan angka
        //     ->assertSeeText('Product 100');

        $this->get('/catagories/wira')
            ->assertSeeText('File not found 404');
    }

    // Test Route Parameter Optional (?)
    public function testRouteParameterOptional()
    {

        $this->get('/users/Wira')
            ->assertSeeText('User Wira');

        $this->get('/users/')
            ->assertSeeText('User');

        $this->get('/users/')
            ->assertSeeText('User 404');
    }

    // Test Route Conflict
    public function testRouteConflict()
    {

        $this->get('/conflict/budi')
            ->assertSeeText("Conflict budi");
        
        $this->get('/conflict/wira')
            ->assertSeeText("Conflict Muhammad Wira Hadi");
        
        
    }
}
