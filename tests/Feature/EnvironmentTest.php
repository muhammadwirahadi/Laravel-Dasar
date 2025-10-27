<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Env;
use Tests\TestCase;

use function PHPUnit\Framework\assertEquals;

class EnvironmentTest extends TestCase
{
    public function testGet() {

        $youtube = env('YOUTUBE');

        self::assertEquals("Bayeklodon", $youtube);
    }

    public function testDefaultEnv(){
        $author = Env::get("AUTHOR", "Wira");

        self::assertEquals("Wira", $author);
    }
}
