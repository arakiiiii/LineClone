<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class LineUsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function users(){

        $data = DB::table('user_info')->where('user_id',Auth::user()->id)->first();
        if($data==null){
            DB::table('user_info')
            ->insert([
                "user_id"=>Auth::user()->id,
                "comment"=>"",
                "nickname"=>Auth::user()->name,
            ]);
        }

        $param = [
            'users' => DB::table('users')->orderBy('id')->get(),
            'usersInfo'=> DB::table('user_info')->orderBy('user_id')->get(),
            'friends'=>DB::table('friends')->where('myid',Auth::user()->id)->get()
        ];
        return view('line.users',$param);
    }

    public function befriend(Request $request){
        $a = DB::table('friends')
        ->where("myid",Auth::user()->id)
        ->where("yourid",$request->date)
        ->first();
        if($a == null){
            DB::table('friends')->insert([
                'myid'=>Auth::user()->id,
                'yourid'=>$request->date,
                ]);
            return "解除";
        } else {
            DB::table('friends')
            ->where("myid",Auth::user()->id)
            ->where("yourid",$request->date)
            ->delete();
            return "追加";
        }
        // $date = DB::table('friends')->where("myid",Auth::user()->id)->get(); //全友達のidを取得
        // dd($date);
    }
}
