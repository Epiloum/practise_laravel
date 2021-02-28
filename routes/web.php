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
Route::get('/test/mw', function () {
    return 'mwtest(' . $_GET['value'] . ') ' . date('Y-m-d H:i:s');
})->middleware(App\Http\Middleware\MwTest::class);

// Controller & DB Query Test
Route::get('/test/db', [App\Http\Controllers\DbTest::class, 'test_query']);

Route::get('/test/collection', function () {
    $res = [];

    // contains()
    $orders = App\Models\Order::all();
    $res['contains1'] = $orders->contains('user_buy', '=', '160');
    $res['contains2'] = $orders->contains('user_buy', '=', '1000');

    // intersect() and diff()
    $res['intersect'] = $orders->intersect(App\Models\Order::where('amt', '>=', 100000)->get());
    $res['diff'] = $orders->diff(App\Models\Order::where('amt', '<', 100000)->get());

    // only() and except()
    $res['only'] = $orders->only([1,3,5]);
    $res['except'] = $orders->except([1,3,5,7,9,11,13,15]);

    // find()
    $res['find'] = $orders->find([1,3,5]);

    // modelkeys()
    $res['modelkeys'] = $orders->modelkeys();

    // makeVisible() and makeHidden() / It doesn't work clone! Is it Singleton?!
    $tmp1 = App\Models\Order::all();
    $tmp2 = App\Models\Order::all();
    $res['makeHidden'] = $tmp1->makeHidden(['user_buy', 'product_no', 'requirements', 'created_at', 'updated_at']);
    $res['makeVisible'] = $tmp2->makeHidden(['user_buy', 'product_no', 'requirements', 'created_at', 'updated_at'])->makeVisible(['product_no']);

    // unique()
    $res['unique'] = $orders->unique('product_no');

    // fresh(), load(), loadMissing(), toQuery()

    // Export
    ob_start();
    echo '<table>';
    foreach ($res as $k => $v) {
        echo '<tr>';
        echo '<th>' . $k . '</th><td>';
        if(is_iterable($v)) {
            foreach($v as $v2) {
                echo $v2 . '<br />';
            }
        } else {
            var_dump($v);
        }
        echo '</td>';
        echo '</tr>';
    }
    echo '</table>';

    return ob_get_clean();
});

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
        'email' => App\Models\User::select(['email'])->whereColumn('no', 'orders.user_buy'),
        'grade' => App\Models\User::select(['grade'])->whereColumn('no', 'orders.user_buy')
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

Route::get('/order/list/{user_no}', function ($user_no) {
    // Practise querying relations by Eloquent ORM
    $user = App\Models\User::where('no', $user_no)->first();

    return view('user_list', [
        'users' => [$user]
    ]) . view('order_list', [
        'orders' => $user->buyOrders()->get(),
        'relation' => true
    ]);
})->where('user_no', '[0-9]+');
