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

// Error
Route::get('/err', function () {
    return 'Error Page (' . date('Y-m-d H:i:s') . ')';
});

// Sign in for Validation Test
Route::get('/signin', [App\Http\Controllers\SignIn::class, 'frm']);
Route::post('/signin/proc', [App\Http\Controllers\SignIn::class, 'proc']);

// Commerce Prototype
Route::get('/user/list', function(){
    // Practise SELECT by Eloquent ORM
    $users = App\Models\User::all();

    ob_start();

    echo '<table>';
    echo '<thead>';    
    echo '<tr>';
    echo '<th>no</th>';
    echo '<th>Name</th>';
    echo '<th>Email</th>';
    echo '<th>Grade</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    foreach ($users as $v) {
        echo '<tr>';
        echo '<td>' . $v->no . '</td>';
        echo '<td>' . $v->name . '</td>';
        echo '<td>' . $v->email . '</td>';
        echo '<td>' . $v->grade . '</td>';
        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';

    return '<pre>' . ob_get_clean() . '</pre>';
});

Route::get('/order/list/{user}', function($user){    
    // Practise Subquery by Eloquent ORM
    $orders = App\Models\Order::addSelect([
        'email' => App\Models\User::select(['email'])->whereColumn('no', 'orders.user_buy'),
        'grade' => App\Models\User::select(['grade'])->whereColumn('no', 'orders.user_buy')
    ]);

    ob_start();

    echo '<table>';

    echo '<thead>';    
    echo '<tr>';
    echo '<th>Buyer</th>';
    echo '<th>Buyer`s Email</th>';
    echo '<th>Buyer`s Grade</th>';
    echo '<th>Product</th>';
    echo '<th>Qty</th>';
    echo '<th>Amount</th>';
    echo '<th>Requirements</th>';
    echo '</tr>';
    echo '</thead>';

    echo '<tbody>';

    foreach ($orders->get() as $v) {
        echo '<tr>';
        echo '<td>' . $v->user_buy . '</td>';
        echo '<td>' . $v->email . '</td>';
        echo '<td align="right">' . $v->grade . '</td>';
        echo '<td>' . $v->product_no . '</td>';
        echo '<td align="right">' . number_format($v->qty) . '</td>';
        echo '<td align="right">' . number_format($v->amt) . '</td>';
        echo '<td>' . $v->requirements . '</td>';
        echo '</tr>';
    }

    echo '</tbody>';

    echo '<tfoot>';    
    echo '<tr>';
    echo '<th>Count</th>';
    echo '<th colspan="2" align="right">' . number_format($orders->count()) . '</th>';
    echo '<th>Total of Amount</th>';
    echo '<th colspan="2" align="right">' . number_format($orders->sum('amt')) . '</th>';
    echo '<th></th>';
    echo '</tr>';
    echo '</tfoot>';

    echo '</table>';

    return '<pre>' . ob_get_clean() . '</pre>';
})->where('user', '[0-9]+');