<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Career;
use App\User;
use App\obj;

class CareerController extends Controller
{
     public function createCareer(Request $request){

    	$newCareer = new Career();
    	$newCareer->initialize(
           $request->works_at,
           $request->works_since,
           $request->works_to,
           $request->works_what,
           $request->works_as
    	);
    	return $newCareer->id;

    }

    public function retriveCareer(Request $request){
        $user = User::find($request->user);
       if(!$user) return 'invalid' ;
       $edus = $user->careers()->get();
       $array = [];
       foreach($edus as $edu){
        if(obj::find($edu->object_id)->isAvailable(auth()->user()->id))
          array_push($array, $edu);
       }
       return $array ;
    }


    public function updateCareer(Request $request){
      $newCareer = Career::find($request->career_id);
      if($newCareer){
        $newCareer->works_at = $request->works_at;
        $newCareer->works_what = $request->works_what;
        $newCareer->works_since = $request->works_since;
        $newCareer->works_to = $request->works_to;
        $newCareer->works_as = $request->works_as;
        $newCareer->update();
        return 'done';
      }else return 'not found';
    }

    public function deleteCareer(Request $request){
          Career::where('id','=',$request->about_id)->delete();
          return 'done';
      }


}
