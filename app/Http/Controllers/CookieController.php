<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CookieController extends Controller
{
    public function createCookie(Request $request): Response {
        return response("Hello Cookie")
            ->cookie("User-Id", "Wira", 1000, "/")
            ->cookie("Is-Member", "true", 100, "/") ;
    }
}
