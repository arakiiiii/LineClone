<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class LineController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('login');
    }

}
