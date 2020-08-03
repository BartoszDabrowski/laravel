<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Auth;

class DataController extends Controller
{
    public function balance(){
        $mail = Auth::user()->email;
        $test = DB::select("select balance, loan from users where email = '$mail'");
        $tab = json_decode(json_encode($test),true);
        return view('balance',['tab' => $tab],['name'=> Auth::user()->name]);
        //return $tab;
    }
    public function history(Request $req){
        $mail = Auth::user()->email;
        $id = DB::select("select id from users where email = '$mail'");
        $test = json_decode(json_encode($id),true);
        $idi = (int)$test[0]['id'];
        //$stest = DB::select("select * from transfers where sender_id = $idi");
        
        $stest = DB::select("SELECT users.name, users.email ,transfers.amount, transfers.date FROM users JOIN transfers on users.id=receiver_id where sender_id = $idi");
        
        //$rtest = DB::select("select * from transfers where receiver_id = $idi");
        $rtest = DB::select("SELECT users.name, users.email ,transfers.amount, transfers.date FROM users JOIN transfers on users.id=sender_id where receiver_id = $idi");
        $rtab = json_decode(json_encode($rtest),true);
        $stab = json_decode(json_encode($stest),true);
        //return view('history',['rtab' => $rtab],['stab'=>$stab],['name'=> Auth::user()->name] );
        return view('history', ['stab'=>$stab],['rtab'=>$rtab] );
        //return [['rtab'=>$rtab], ['stab'=>$stab]];

    }
}
