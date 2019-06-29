<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\User;

class LineMypageController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');

    }

    public function mypage(){
        $data = [];
        $FriendsID = DB::table('friends')->where('myid',Auth::user()->id)->get('yourid');
        for($i=0; $i<count($FriendsID); $i++){
            array_push($data,$FriendsID[$i]->yourid);
        }
        $usersData = DB::table('user_info')->whereIn('user_id',$data)->get();
        $param = [
            'myData' => Auth::user(),
            'myInfoData' => DB::table('user_info')->where('user_id',Auth::user()->id)->first(),
            "friends" => $usersData,
        ];
        return view('line.mypage',$param);
    }

    public function edit(Request $request)
    {
        //エラー処理
        $validate = new LineValidateController;
        $validate->editValidate($request);

        //userの情報
        DB::table('users')
        ->where('name',Auth::user()->name)
        ->update([
            'name'=>$request->name,
            'email'=>$request->email
        ]);

        //user_infoの情報
        $userID = $request->user_id;

        $a = DB::table('user_info')->where('user_id',$userID)->first();
        if($a!=null){
            DB::table('user_info')
            ->where('user_id',Auth::user()->id)
            ->update([
                'nickname'=>$request->nickname,
                'comment'=>$request->comment
            ]);
        }

        return redirect()->action("LineMypageController@mypage");
    }
}
