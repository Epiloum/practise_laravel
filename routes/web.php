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

// Index
Route::get('/', function () {
    return view('welcome');
});

// Router Test
Route::get('/test', function () {
    return date('Y-m-d H:i:s');
});

// Middleware Test
Route::get('/mwtest', function () {
    return 'mwtest(' . $_GET['value'] . ') ' . date('Y-m-d H:i:s');
})->middleware(App\Http\Middleware\MwTest::class);

// Controller & DB Query Test
Route::get('/dbtest', [App\Http\Controllers\DbTest::class, 'test_query']);

// Sign in for Validation Test
Route::get('/signin', [App\Http\Controllers\SignIn::class, 'frm']);
Route::post('/signin/proc', [App\Http\Controllers\SignIn::class, 'proc']);

// Commerce Prototype
Route::get('/user/list', function(){
    // Practise SELECT by Eloquent ORM
    return view('user_list', [
        'users' => App\Models\User::all()
    ]);
});

Route::get('/user/list/buy', function(){
    // Practise querying relationship existence by Eloquent ORM
    return view('user_list', [
        'users' => App\Models\User::has('buyOrders')->get()
    ]);
});

Route::get('/user/list/didntbuy', function(){
    // Practise querying relationship existence by Eloquent ORM
    return view('user_list', [
        'users' => App\Models\User::doesntHave('buyOrders')->get()
    ]);
});

Route::get('/order/list/subquery', function(){
    // Practise Subquery by Eloquent ORM
    $orders = App\Models\Order::addSelect([
        'email' => App\Models\User::select(['email'])->whereColumn('no', 'orders.user_buy'),
        'grade' => App\Models\User::select(['grade'])->whereColumn('no', 'orders.user_buy')
   ])->get();

    return view('order_list', [
        'orders' => $orders,
        'relation' => false
    ]);
});

Route::get('/order/list/relation', function(){
    // Practise Eloquent Relationships
    $res = App\Models\Order::all();
    $orders = [];

    foreach ($res as $v) {
        $orders[] = $v;
    }

    return view('order_list', [
        'orders' => $orders,
        'relation' => true
    ]);
});

Route::get('/order/list/{user_no}', function($user_no){
    // Practise querying relations by Eloquent ORM
    $user = App\Models\User::where('no', $user_no)->first();

    return view('user_list', [
        'users' => [$user]
    ]) . view('order_list', [
        'orders' => $user->buyOrders()->get(),
        'relation' => true
    ]);
})->where('user_no', '[0-9]+');
