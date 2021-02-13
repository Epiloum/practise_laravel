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

<<<<<<< HEAD
Route::get('hello', function () {
    return 'Hello World!';
});

Route::get('{foo}', function ($foo) {
    return $foo . ' ' . date('Y-m-d H:i:s');
});
=======
Route::get('/dbtest', [App\Http\Controllers\DbTest::class, 'test']);
>>>>>>> feature/routing-to-controller
