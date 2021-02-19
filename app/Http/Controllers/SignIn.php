<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SignIn extends Controller
{
    public function frm()
    {
        return view('signin');
    }

    public function proc(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'bail|required||max:15',
            'pw' => 'required',
        ]);

        ob_start();
        var_dump($validatedData);

        return '<pre>' . ob_get_clean() . '</pre>';
    }
}
