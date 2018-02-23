<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sport;
use App\User;
use App\obj;

class SportController extends Controller
{
     public function createSport(Request $request){

    	$newHobby = new Sport();
    	$newHobby->initialize(
           $request->name
    	);
    	return $newHobby->id;

    }

    public function retriveSport(Request $request){
        $user = User::find($request->user);
       if(!$user) return 'invalid' ;
       $edus = $user->sports()->get();
       $array = [];
       foreach($edus as $edu){
        if(obj::find($edu->object_id)->isAvailable(auth()->user()->id))
          array_push($array, $edu);
       }
       return $array ;
    }

        public function updateSport(Request $request){
      $sport = Sport::where('id','=',$request->sport_id)->update([
        'name'=>$request->name,

      ]);
      return 'done';
    }

    public function deleteSport(Request $request){
      Sport::where('id','=',$request->about_id)->delete();
      return 'done';
  }
}
