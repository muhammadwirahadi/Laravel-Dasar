<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ConfigurationTest extends TestCase
{
    public function testConfig()
    {
        // configurasi do laravel
        $firstname = config('contoh.author.first');
        $lastname = config('contoh.author.last');
        $email = config('contoh.email');
        $web = config('contoh.web');

        self::assertEquals("Muhammad", $firstname);
        self::assertEquals("Wira Hadi", $lastname);
        self::assertEquals("muhammadwirahadi@gmail.com", $email);
        self::assertEquals("https://www.muhammadwirahadi.com", $web);

    }
}
