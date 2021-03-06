<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Education;
use App\User;
use App\obj;

class EducationController extends Controller
{
     public function createEducation(Request $request){

      $newEducation = new Education();
      $newEducation->initialaize(
           $request->study_at,
           $request->study_what,
           $request->study_since,
           $request->study_to,
           $request->grade
      );
    return  $newEducation->id;

    }

    public function retriveEducation(Request $request){
       $user = User::find($request->user);
       if(!$user) return 'invalid' ;
       $edus = $user->educations()->get();
       $array = [];
       foreach($edus as $edu){
        if(obj::find($edu->object_id)->isAvailable(auth()->user()->id))
          array_push($array, $edu);
       }
       return $array ;

    }

    public function updateEducation(Request $request){
      $newEducation = Education::find($request->education_id);
       if($newEducation){

        $newEducation->study_at = $request->study_at;
        $newEducation->study_what = $request->study_wha;
        $newEducation->study_since = $request->study_since;
        $newEducation->study_to = $request->study_to;
        $newEducation->grade = $request->grade;
        $newEducation->update();
      return 'done';
         }
    else return 'not found';
    }

    public function deleteEducation(Request $request){
      Education::where('id','=',$request->about_id)->delete();
      return 'done';
  }
}
