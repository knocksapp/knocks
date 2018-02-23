<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\High_education;
use App\User;
use App\obj;

class HighEducationController extends Controller
{
     public function createHighEducation(Request $request){

    	$newEducation = new High_education();
    	$newEducation->initialize(
           $request->study_at,
           $request->study_what,
           $request->study_since,
           $request->study_to,
           $request->grade
    	);
    	return $newEducation->id;

    }

    public function retriveHighEducation(Request $request){
        $user = User::find($request->user);
       if(!$user) return 'invalid' ;
       $edus = $user->highEducations()->get();
       $array = [];
       foreach($edus as $edu){
        if(obj::find($edu->object_id)->isAvailable(auth()->user()->id))
          array_push($array, $edu);
       }
       return $array ;
    }
    
    public function updateHighEducation(Request $request){
      $newEducation = High_education::where('id','=',$request->higheducation_id)->update([
        'study_at' => $request->study_at,
        'study_what' => $request->study_what,
        'study_since' => $request->study_since,
        'study_to' => $request->study_to,
        'grade' => $request->grade
      ]);
      return $request->higheducation_id;
    }

    public function deleteHighEducation(Request $request){
          High_education::where('id','=',$request->about_id)->delete();
          return 'done';
      }
}
