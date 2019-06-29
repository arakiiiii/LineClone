<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LineValidateController extends Controller
{
    public function editValidate(Request $request){
        $request->validate([
            "name" => "required|max:15",
            "email" => "required|email",
            'comment' => 'max:200',
            'nickname' => 'required|max:15',
        ]);
    }

    public function messageValidate(Request $request){

        $request->validate([
            "message" => "required|max:200",
            "yourid" => "required"
        ]);
    }
}
