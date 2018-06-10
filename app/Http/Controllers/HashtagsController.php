<?php

namespace App\Http\Controllers;

use App\hashtags;
use Illuminate\Http\Request;

class HashtagsController extends Controller {
	//
	public function lazy(Request $req) {
		$q = hashtags::where('hashtag', '=', $req->hashtag);
		return $q->exists() ? $q->first()->count : 0;
	}

	public function findHashTag(Request $req, $hashtag) {
		$hashtagQuery = hashtags::where('hashtag', '=', '#' . $hashtag);
		if (!$hashtagQuery->exists()) {
			return redirect()->action('UserController@lost');
		} else {
			$currentHashtag = $hashtagQuery->first();
		 return view('trend.trend', ['trend' => $currentHashtag]);
		}
	}
	   public function retriveTrendKnocks(Request $request){
      $hash = hashtags::find($request->user);
      if($hash)
      return $hash->retriveKnocks();
    }

    public function retriveOlderTrendKnocks(Request $request){
       $hash = hashtags::find($request->user);
      if($hash)
      return $hash->retriveOlderKnocks($request->min);
    }

    public function retriveNewerTrendKnocks(Request $request){
      $hash = hashtags::find($request->user);
      if($hash)
      return $hash->retriveNewerKnocks($request->max);
    }
}
