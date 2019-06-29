<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class LineHomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data = DB::table('user_info')->where('user_id',Auth::user()->id)->first();
        if($data==null){
            DB::table('user_info')
            ->insert([
                "user_id"=>Auth::user()->id,
                "comment"=>"",
                "nickname"=>Auth::user()->name,
            ]);
        }

        $data = [];
        $FriendsID = DB::table('friends')->where('myid',Auth::user()->id)->get('yourid');
        for($i=0; $i<count($FriendsID); $i++){
            array_push($data,$FriendsID[$i]->yourid);
        }
        $usersData = DB::table('user_info')->whereIn('user_id',$data)->get();

        $myid = Auth::user()->id;

        $param = [
            "friends" => $usersData,
        ];
        return view("line.index",$param);
    }

    public function message(Request $request){
        //エラー処理
        $validate = new LineValidateController;
        $validate->messageValidate($request);

        $myid = Auth::user()->id;
        $yourid = $request->yourid;
        $message = $request->message;

        DB::table("messages")->insert([
            "myid" => $myid,
            "yourid" => $yourid,
            "message" => $message,
            "created_at" => date('Y/m/d H:i:s'),
        ]);


        return $message;
    }

    public function show(Request $request){
        $yourid = $request->yourid;
        $myid = Auth::user()->id;
        $MyMessages = DB::table("messages")->where([["myid",$myid],["yourid",$yourid]])
                    ->orWhere([["myid",$yourid],["yourid",$myid]])
                    ->orderBy("id","desc")
                    ->get();

        // $messages = array();
        // $myNumber = 0;
        // $yourNumber = 0;
        // for($i=1; $i<=$length->id; $i++){
        //     if($myNumber <= count($MyMessages)){
        //         if($MyMessages[$myNumber]->id == $i){
        //             printf($MyMessages[$myNumber]->id);
        //             printf(' ');
        //             array_push($messages, $MyMessages[$myNumber]);
        //             $myNumber += 1;
        //         }
        //     }
        //     if($yourNumber <= count($YourMessages)){
        //         if($YourMessages[$yourNumber]->id == $i){
        //             printf($YourMessages[$yourNumber]->id);
        //             printf(' ');
        //             array_push($messages, $YourMessages[$yourNumber]);
        //             $yourNumber += 1;
        //         }
        //     }
        // }
        return $MyMessages;
    }
}
