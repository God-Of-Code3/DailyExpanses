<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function register() {
        return view('register');
    }

    public function handleRegister() {
        return view('register');
    }
}
