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

Route::get('/phpinfo', function () {
    ob_start();
    phpinfo();
    return ob_get_clean();
});

// Resource Controller
Route::resource('photos', App\Http\Controllers\PhotoController::class);

// Router Test
Route::get('/test', function () {
    return date('Y-m-d H:i:s');
});

// Middleware Test
Route::get('/test/mw', function () {
    return 'mwtest(' . $_GET['value'] . ') ' . date('Y-m-d H:i:s');
})->middleware(App\Http\Middleware\MwTest::class);

// Controller & DB Query Builder Test
Route::get('/test/db', [App\Http\Controllers\DbTestController::class, 'testQuery']);
Route::get('/test/db/closure', [App\Http\Controllers\DbTestController::class, 'testClosure']);
Route::get('/test/db/collection', [App\Http\Controllers\DbTestController::class, 'testCollection']);

// Queue TEst
Route::get('/test/queue', [App\Http\Controllers\QueueTestController::class, 'test']);

// Sign in for Validation Test
Route::get('/signin', [App\Http\Controllers\SignIn::class, 'frm']);
Route::post('/signin/proc', [App\Http\Controllers\SignIn::class, 'proc']);

// Commerce Prototype
Route::get('/user/list', function () {
    // Practise SELECT by Eloquent ORM
    return view('user_list', [
        'users' => App\Models\User::all()
    ]);
});

Route::get('/user/list/buy', function () {
    // Practise querying relationship existence by Eloquent ORM
    return view('user_list', [
        'users' => App\Models\User::has('buyOrders')->get()
    ]);
});

Route::get('/user/list/didntbuy', function () {
    // Practise querying relationship existence by Eloquent ORM
    return view('user_list', [
        'users' => App\Models\User::doesntHave('buyOrders')->get()
    ]);
});

Route::get('/order/list/subquery', function () {
    // Practise Subquery by Eloquent ORM
    $orders = App\Models\Order::addSelect([
        'email' => App\Models\User::select(['email'])->whereColumn('id', 'orders.user_buy'),
        'grade' => App\Models\User::select(['grade'])->whereColumn('id', 'orders.user_buy')
   ])->get();

    return view('order_list', [
        'orders' => $orders,
        'relation' => false
    ]);
});

Route::get('/order/list/relation', function () {
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

Route::get('/order/list/{user_id}', function ($user_id) {
    // Practise querying relations by Eloquent ORM
    $user = App\Models\User::where('id', $user_id)->first();

    return view('user_list', [
        'users' => [$user]
    ]) . view('order_list', [
        'orders' => $user->buyOrders()->get(),
        'relation' => true
    ]);
})->where('user_id', '[0-9]+');

Route::get('/product/list', function () {
    $products = App\Models\Product::withCount('order')->get();

    return view('product_list', [
        'products' => $products,
        'orderCount' => true
    ]);
});

Route::get('fee/list', function () {
    // Practise querying to morph relations by Eloquent ORM
    $fees = App\Models\Fee::whereHasMorph(
        'billed',
        ['App\Models\Order', 'App\Models\Product'],
        function (Illuminate\Database\Eloquent\Builder $query, $type) {
            $query->where('amt', '>=', '100');

            if ($type === 'App\Models\Product') {
                $query->where('billed_id', '<=', '5');
            }
        })->get();

    return strval($fees);
});

Route::get('fee/count', function () {
    // Counting Related Models On Morph To Relationships
    $fees = App\Models\Fee::with([
        'billed' => function (Illuminate\Database\Eloquent\Relations\MorphTo $morphTo) {
            $morphTo->morphWithCount(
                [
                    App\Models\Order::class => ['buyer'],
                    App\Models\Product::class => ['user']
                ]
            );
        }
    ])->get();

    return strval($fees);
});

Route::get('fee/user', function () {
    // Nested Eager Loading
    $orders = App\Models\Order::with('product.user')->first();

    return strval($orders);
});
