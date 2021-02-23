<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DbTest extends Controller
{
    public function test_connection()
    {
        $users = DB::connection('mysql');
        ob_start();
        var_dump($users);

        return '<pre>' . ob_get_clean() . '<pre>';
    }

    public function test_query()
    {
        $users = DB::connection('mysql')->select('select * from users where no = ?', [7, 11,28]);
        ob_start();
        var_dump($users);

        return '<pre>' . ob_get_clean() . '<pre>';
    }
}
