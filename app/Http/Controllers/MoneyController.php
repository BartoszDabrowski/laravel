<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Auth;

class MoneyController extends Controller
{
    public function loan(Request $req){
        $mail = Auth::user()->email;
        if ($mail == $req['mail'])
        {
            $test = DB::select("select balance, loan from users where email = '$mail'");
            $tab = json_decode(json_encode($test),true);
            DB::table('users')->where('email',$mail)->update(['balance' => $tab[0]['balance']+$req['amount']]);
            DB::table('users')->where('email',$mail)->update(['loan' => $tab[0]['loan']+$req['amount']]);

        //DB::
            return view('succeded',['name'=> Auth::user()->name]);
        }else return view('unlucky',['name'=> Auth::user()->name]);
        
    }
    public function transfer(Request $req){
        $mail = Auth::user()->email;
        if($mail == $req['smail'])
        {
            $test = DB::select("select id, balance from users where email = '$req[smail]'");
            $tab = json_decode(json_encode($test),true);
            $test1 = DB::select("select id, balance from users where email = '$req[rmail]'");
            $tab1 = json_decode(json_encode($test1),true);
             if($tab[0]['balance']>$req['amount']){
                 DB::table('users')->where('email',$req['smail'])->update(['balance' => $tab[0]['balance']-$req['amount']]);
                 DB::table('users')->where('email',$req['rmail'])->update(['balance' => $tab1[0]['balance']+$req['amount']]);
                 DB::table('transfers')->insert(
                     ['sender_id' => $tab[0]['id'],
                      'receiver_id' => $tab1[0]['id'],
                      'amount' => $req['amount']]
                 );
                 return view('succeded', ['name'=> Auth::user()->name]);
                 //return $tab1;
             }else return view('unlucky',['name'=> Auth::user()->name]);
        }else return view('unlucky',['name'=> Auth::user()->name]);

    }

}
