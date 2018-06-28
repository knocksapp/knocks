<?php

namespace App\Http\Controllers;

use App\User;
use App\Candy_session;
use Illuminate\Http\Request;

class CandySessionController extends Controller
{
    //
    public function retriveAllLogs(Request $request) {
  	return Candy_session::get()->pluck('id');
  	}

    public function retriveLog(Request $request)
    {
      $log = Candy_session::where('id','=',$request->id)->get()->pluck('log');
      return $log;

    }

}
