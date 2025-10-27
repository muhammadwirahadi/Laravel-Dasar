<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ViewTest extends TestCase
{

    public function testView()
    {
        $this->get('/hallo')
            ->assertSeeText('Hello Muhammad Wira Hadi');

        $this->get('/hallo-again')
            ->assertSeeText('Hello Muhammad Wira Hadi');
    }

    public function testNested()
    {

        $this->get('/hallo-world')
            ->assertSeeText('World Muhammad Wira Hadi');
    }

    // Test View Tanpa Route
    public function testTemplate()
    {
        $this->view('hallo', ['name' => 'Muhammad Wira Hadi'])
            ->assertSeeText('Hello Muhammad Wira Hadi');
        $this->view('hallo.world', ['name' => 'Muhammad Wira Hadi'])
            ->assertSeeText('World Muhammad Wira Hadi');
    }


}
