<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Config;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use function PHPUnit\Framework\assertEquals;

class FacadeTest extends TestCase
{
    public function testConfig(){

        // bisa juga menggunkaan kaya begini
        $config = $this->app->make('config');
        $firstName3 = $config->get('contoh.author.first');

        // pertama kali buat menggunkan ini 
        $firstName = config('contoh.author.first');

        // menggunakan facade
        $firstName2 = Config::get('contoh.author.first');

        self::assertEquals($firstName, $firstName2);
    
        var_dump(Config::all());  // var_dump($config->all()); -----> bisa juga sepert ini 
     
    }


    public function testFacadeMock() {
        Config::shouldReceive('get')
            ->with('contoh.author.first')
            ->andReturn('Wira Keren');

        $firstName = Config::get('contoh.author.first');

        self::assertEquals('Wira Keren', $firstName);
    }


}
