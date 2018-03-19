<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\obj;
use App\ignore_object;

class ObjController extends Controller
{
    public function hide(Request $request){
    	$request->validate(['object' => 'required']);
    	$ignored = new ignore_object();
    	$ignored->object_id = $request->object;
    	$ignored->user_id = auth()->user()->id;
    	$ignored->save();
    	return 'done';
    }
}
