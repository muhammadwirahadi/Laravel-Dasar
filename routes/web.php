<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// route
Route::get('/mwh', function () {
    return "Hallo, Muhammad Wira Hadi :)";
});

// redirect
Route::redirect('/youtube', '/mwh');

// fallback
Route::fallback(function () {
    return "File not found 404";
});

// render ke view
// contoh 1
Route::view('/hallo', 'hallo', ['name' => 'Muhammad Wira Hadi']);

// contoh 2
Route::get('/hallo-again', function () {
    return view('hallo', ['name' => 'Muhammad Wira Hadi Keren']);
});

// contoh nested folder hello/world.blade.php
Route::get('/hallo-world', function () {
    return view('hallo.world', ['name' => 'Muhammad Wira Hadi']);
});

// ---------------------------------------------------------------------------------------------

// Route Parameter
Route::get('/products/{id}', function ($productId) {
    return "Product $productId";
});

Route::get('/products/{product}/items/{item}', function ($productId, $itemId) {
    return "Product $productId, Item $itemId";
});

// Route Paramater Regex
Route::get('/catagories/{id}', function ($catagoryId) {
    return "Catagory $catagoryId";
})->where('id', '[0-9]+');

// Route::get('/catagories/{id}', function ($catagoryId) {
//     return "Catagory $catagoryId";
// })->where('id', '[0-9]+')->where('items', '[XXX]'); ---> bisa juga lebih dari 1


// Route Parameter Optional (?)
Route::get('/users/{id?}', function ($userId = '404'){ //--> harus di kasih default (404 atau any)
    return "User $userId";
});

// ---------------------------------------------------------------------------------------------

// Routes Conflict
//  ----> kalau di atas tidak akan error
Route::get('/conflict/wira', function () {
    return "Conflict Muhammad Wira Hadi";
});

Route::get('/conflict/{name}', function ($name) {
    return "Conflict $name";
});

// ----> kalau di bawah akan error
// Route::get('/conflict/wira', function () {
//     return "Conflict Muhammad Wira Hadi";
// });

// ---------------------------------------------------------------------------------------------


