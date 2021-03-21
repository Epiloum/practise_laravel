<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DbTestController extends Controller
{
    public function testConnection(): string
    {
        $users = DB::connection('mysql');
        ob_start();
        var_dump($users);

        return '<pre>' . ob_get_clean() . '<pre>';
    }

    public function testQuery(): string
    {
        $users = DB::connection('mysql')->select('select * from users where id = ?', [7, 11, 28]);
        ob_start();
        var_dump($users);

        return '<pre>' . ob_get_clean() . '<pre>';
    }

    public function testClosure()
    {
        $users = DB::table('users')
            ->where(function ($query) {
                $query
                    ->where('name', 'MzmQjX5e5FIhMG7CXK')
                    ->orWhere('name', 'LIWmMJyYgFzUmXfakq');
            })
            ->where('updated_at', null)
            ->get();
        ob_start();
        var_dump($users);

        return '<pre>' . ob_get_clean() . '<pre>';
    }

    public function testCollection(): string
    {
        $res = [];

        // contains()
        $orders = \App\Models\Order::all();
        $res['contains1'] = $orders->contains('user_buy', '=', '213');
        $res['contains2'] = $orders->contains('user_buy', '=', '1470');

        // intersect() and diff()
        $res['intersect'] = $orders->intersect(\App\Models\Order::where('amt', '>=', 100000)->get());
        $res['diff'] = $orders->diff(\App\Models\Order::where('amt', '<', 100000)->get());

        // only() and except()
        $res['only'] = $orders->only([1, 3, 5]);
        $res['except'] = $orders->except([1, 3, 5, 7, 9, 11, 13, 15]);

        // find()
        $res['find'] = $orders->find([1, 3, 5]);

        // modelkeys()
        $res['modelkeys'] = $orders->modelkeys();

        // makeVisible() and makeHidden() / It doesn't work clone! Is it Singleton?!
        $tmp1 = \App\Models\Order::all();
        $tmp2 = \App\Models\Order::all();
        $res['makeHidden'] = $tmp1->makeHidden(['user_buy', 'product_id', 'requirements', 'created_at', 'updated_at']);
        $res['makeVisible'] = $tmp2->makeHidden(
            ['user_buy', 'product_id', 'requirements', 'created_at', 'updated_at']
        )->makeVisible(['product_id']);

        // unique()
        $res['unique'] = $orders->unique('product_id');

        // fresh(), load(), loadMissing(), toQuery()

        // Export
        ob_start();
        echo '<table>';
        foreach ($res as $k => $v) {
            echo '<tr>';
            echo '<th>' . $k . '</th><td>';
            if (is_iterable($v)) {
                foreach ($v as $v2) {
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
    }
}
