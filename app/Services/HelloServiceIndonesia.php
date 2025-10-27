<?php

namespace App\Services;

class HelloServiceIndonesia implements HelloService 
{
    public function hello(string $nama): string {
        return "Hello $nama";
    }
}



?>