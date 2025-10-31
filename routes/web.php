<?php

use App\Http\Controllers\CookieController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\HelloController;
use App\Http\Controllers\InputController;
use App\Http\Controllers\RedirectController;
use App\Http\Controllers\ResponseController;
use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

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
})->name('product.detail'); //---> menamakan route

Route::get('/products/{product}/items/{item}', function ($productId, $itemId) {
    return "Product $productId, Item $itemId";
})->name('product.item.detail'); //---> menamakan route

// Route Paramater Regex
Route::get('/catagories/{id}', function ($catagoryId) {
    return "Catagory $catagoryId";
})->where('id', '[0-9]+')->name('catagory.detail');

// Route::get('/catagories/{id}', function ($catagoryId) {
//     return "Catagory $catagoryId";
// })->where('id', '[0-9]+')->where('items', '[XXX]'); ---> bisa juga lebih dari 1


// Route Parameter Optional (?)
Route::get('/users/{id?}', function ($userId = '404') { //--> harus di kasih default (404 atau any)
    return "User $userId";
})->name('user.detail');

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
// contoh menggunakan ketika sudah menamakan route
Route::get('/produk/{id}', function ($id) {
    $link = route('product.detail', ['id' => $id]);
    return "Link $link";
});

Route::get('/produk-redirect/{id}', function ($id) {
    return redirect()->route('product.detail', ['id' => $id]);
});

// ---------------------------------------------------------------------------------------------
// Request
Route::get('/controller/hello/request', [HelloController::class, 'request']);

// Controller
Route::get('/controller/hello/{name}', [HelloController::class, 'hello']);


// Request Input
// get
Route::get('/input/hello', [InputController::class, 'hello']);
// post
Route::post('/input/hello', [InputController::class, 'hello']);

// Request Nested Input
Route::post('/input/hello/first', [InputController::class, 'helloFirstName']);

// Mengambil Semua Input
Route::post('/input/hello/input', [InputController::class, 'helloInput']);

// Mengambil Array Input
Route::post('/input/hello/array', [InputController::class, 'helloArray']);

// ---------------------------------------------------------------------------------------------
// Input Type
Route::post('/input/type', [InputController::class, 'inputType']);

// Filter Request Input
// only
Route::post('/input/filter/only', [InputController::class, 'filterOnly']);

// except
Route::post('/input/filter/except', [InputController::class, 'filterExcept']);

// Marge Input
Route::post('/input/filter/merge', [InputController::class, 'filterMerge']);

// ---------------------------------------------------------------------------------------------
// File Upload
Route::post('/file/upload', [FileController::class, 'upload'])
    ->withoutMiddleware([VerifyCsrfToken::class]);

// Response
Route::get('/response/hello', [ResponseController::class, 'response']);

// HTTP Response Header
Route::get('/response/header', [ResponseController::class, 'header']);

// Reponses view, json, file, download
Route::prefix('/response/type/')->group(function () {
    // Route group
    Route::get('/view', [ResponseController::class, 'responseView']);
    Route::get('/json', [ResponseController::class, 'responseJson']);
    Route::get('/file', [ResponseController::class, 'responseFile']);
    Route::get('/download', [ResponseController::class, 'responseDownload']);
});


// Cookie and Route Controller
Route::controller(CookieController::class)->group(function () {
    Route::get('/cookie/set', 'createCookie');
    // Get Cookie
    Route::get('/cookie/get', 'getCookie');
    // Clear Cookie
    Route::get('/cookie/clear', 'clearCookie');
});



// ---------------------------------------------------------------------------------------------
// Redirect
Route::get('/redirect/from', [RedirectController::class, 'redirectFrom']);
Route::get('/redirect/to', [RedirectController::class, 'redirectTo']);

// Redirect Named routes
Route::get('/redirect/name', [RedirectController::class, 'redirectName']);
Route::get('/redirect/name/{name}', [RedirectController::class, 'redirectHello'])
    ->name('redirect-hello');
Route::get('/redirect/action', [RedirectController::class, 'redirectAction']);

// Redirect to External Domain
Route::get('/redirect/bayek', [RedirectController::class, 'redirectAway']);

// ---------------------------------------------------------------------------------------------
// Middleware
// Middleware Group and Route Middleware and Multiple Route Group

Route::middleware(['contoh:mwh,401'])->prefix('/middleware')->group(function () {
    Route::get('/api', function () {
        return "OK";
    });

    Route::get('/group', function () {
        return "GROUP";
    });
});

// CSRF (Cross Site Request Forgery)
Route::get('/form', [FormController::class, 'form']);
Route::post('/form', [FormController::class, 'submitForm']);

// ---------------------------------------------------------------------------------------------
// Url
Route::get('url/current', function () {
    return URL::full();
});