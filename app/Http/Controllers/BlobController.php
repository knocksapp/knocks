<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Blob;
use App\obj;
use App\User;
use App\Group;

class BlobController extends Controller
{
    public function createRecord(Request $request){
    	$request->validate([
    		'extended' => 'required' ,
    		'duration' => 'required'
    	]);
    	$blob = new Blob();
    	return $blob->recordBlob(json_encode(array(
    		'blob' => $request->extended ,
    		'duration' => $request->duration
    	)));
    }
    public function retriveRecord(Request $request , $id){
    	$blob = Blob::find($id);
    	if($blob == null) return 'invalid'; else {
    		$parent = obj::find($blob->parent_object);
    		if($parent == null) return 'invalid';
    		if(!$parent->isAvailable(auth()->user()->id)) return 'invalid';
    		return response($blob->vnBlob())
            ->header('Content-Type', 'audio/webm');


    	}
    }

     public function retriveRecordMeta(Request $request){
    	$blob = Blob::find($request->id);
    	if($blob == null || $blob->type != 'record') return 'invalid'; else {
    		$parent = obj::find($blob->parent_object);
    		if($parent == null) return 'invalid';
    		if(!$parent->isAvailable(auth()->user()->id)) return 'invalid';
    		return $blob->blobDuration();


    	}
    }

    public function retriveFileMeta(Request $request){
        $blob = Blob::find($request->id);
        if($blob == null || $blob->type != 'File') return 'invalid'; else {
            $parent = obj::find($blob->parent_object);
            if($parent == null) return 'invalid';
            if(!$parent->isAvailable(auth()->user()->id)) return 'invalid';

            return array( 'name' => $blob->index()->name , 'extension' => $blob->extension );


        }
    }

    public function uploadImage(Request $request){
        $request->validate([
            'object' => 'required' ,
        ]);
        $blob = new Blob();
        $upload = $blob->imageBlob(json_encode($request->object));
        if($upload) return $blob->id;
    }

    public function uploadFile(Request $request){
        $request->validate([
            'object' => 'required' ,
        ]);
        $blob = new Blob();
        $upload = $blob->fileBlob(json_encode($request->object));
        if($upload) return $blob->id;
    }

        public function uploadAvatar(Request $request){
        $request->validate([
            'object' => 'required' ,
        ]);
        $blob = new Blob();
        $upload = $blob->avatarBlob(json_encode($request->object));
        $user = User::find(auth()->user()->id); $user->profile_picture = $blob->id;
        $user->update();


        if($upload) return 'done';
    }

    public function uploadGroupPicture(Request $request){
        $request->validate([
            'object' => 'required' ,
        ]);
        $blob = new Blob();
        $upload = $blob->avatarBlob(json_encode($request->object));


        $group = Group::find($request->externals['group_id']); $group->picture = $blob->id;
        $group->update();


        if($upload) return 'done';
    }

    //Cover

    public function uploadCover(Request $request){
        $request->validate([
            'object' => 'required' ,
        ]);
        $blob = new Blob();
        $upload = $blob->coverBlob(json_encode($request->object));
        $user = User::find(auth()->user()->id); $user->cover_picture = $blob->id;
        $user->update();


        if($upload) return 'done';
    }



     public function retriveImage(Request $request , $id){
        $blob = Blob::find($id);
        if($blob == null) return 'invalid'; else {
            if($blob->type != 'image') return 'invalid';
            $parent = obj::find($blob->parent_object);
            if($parent == null) return 'invalid';
            if(!$parent->isAvailable(auth()->user()->id)) return 'invalid';
            return response($blob->retriveImgBlob())
            ->header( 'Content-Disposition', 'inline; filename="Knocks '.User::find($parent->user_id)->username.'\'s Image #'.$id)
            ->header('Content-Type', $blob->extension);


        }
    }

    public function retriveFile(Request $request , $id){
        $blob = Blob::find($id);
        if($blob == null) return 'invalid'; else {
            if($blob->type != 'File') return 'invalid';
            $parent = obj::find($blob->parent_object);
            if($parent == null) return 'invalid';
            if(!$parent->isAvailable(auth()->user()->id)) return 'invalid';
            return response($blob->retriveImgBlob())
            ->header( 'Content-Disposition', 'inline; filename="Knocks\'s File '.$blob->index()->name)
            ->header('Content-Type', $blob->extension);


        }
    }

      public function retriveAvatar(Request $request , $id){
        $user = User::find($id);
        if($user == null) return redirect('snaps/avatar.jpg');
        $pp = $user->profile_picture ;
        if($pp == null) return redirect('snaps/avatar.jpg');
        $blob = Blob::find($pp);
        if($blob == null)return redirect('snaps/avatar.jpg'); else {
            if($blob->type != 'avatar') return redirect('snaps/avatar.jpg');

            return response($blob->retriveImgBlob())
            ->header( 'Content-Disposition', 'inline; filename="Knocks ')
            ->header('Content-Type', $blob->extension);


        }
    }

  public function retriveGroupPicture(Request $request , $id){
        $user = Group::find($id);
        if($user == null) return redirect('snaps/avatar.jpg');
        $pp = $user->picture ;
        if($pp == null) return redirect('snaps/avatar.jpg');
        $blob = Blob::find($pp);
        if($blob == null)return redirect('snaps/avatar.jpg'); else {
            if($blob->type != 'avatar') return redirect('snaps/avatar.jpg');

            return response($blob->retriveImgBlob())
            ->header( 'Content-Disposition', 'inline; filename="Knocks ')
            ->header('Content-Type', $blob->extension);


        }
    }

      public function retriveAvatarCompressed(Request $request , $id){
        $user = User::find($id);
        if($user == null) return redirect('snaps/avatar.jpg');
        $pp = $user->profile_picture ;
        if($pp == null) return redirect('snaps/avatar.jpg');
        $blob = Blob::find($pp);
        if($blob == null)  return redirect('snaps/avatar.jpg'); else {
            if($blob->type != 'avatar') return 'invalid';
            // $parent = obj::find($blob->parent_object);
            // if($parent == null) return 'invalid';
            // if(!$parent->isAvailable(auth()->user()->id)) return 'invalid';
            return response($blob->retriveImgCompressed())
            ->header( 'Content-Disposition', 'inline; filename="Knocks')
            ->header('Content-Type', $blob->extension);


        }
    }
          public function retriveCover(Request $request , $id){
        $user = User::find($id);
        if($user == null) return redirect('snaps/cover.png');
        $pp = $user->cover_picture ;
        if($pp == null) return redirect('snaps/cover.png');
        $blob = Blob::find($pp);
        if($blob == null) return redirect('snaps/cover.png'); else {
            if($blob->type != 'cover') return redirect('snaps/cover.png');
            // $parent = obj::find($blob->parent_object);
            // if($parent == null) return 'invalid';
            // if(!$parent->isAvailable(auth()->user()->id)) return 'invalid';
            return response($blob->retriveImgBlob())
            ->header( 'Content-Disposition', 'inline; filename="Knocks ')
            ->header('Content-Type', $blob->extension);


        }
    }

      public function retriveCoverCompressed(Request $request , $id){
        $user = User::find($id);
        if($user == null) return redirect('snaps/cover.png');
        $pp = $user->cover_picture ;
        if($pp == null) return redirect('snaps/cover.png');
        $blob = Blob::find($pp);
        if($blob == null)  return redirect('snaps/avatar.jpg'); else {
            if($blob->type != 'cover') return redirect('snaps/cover.png');
            // $parent = obj::find($blob->parent_object);
            // if($parent == null) return 'invalid';
            // if(!$parent->isAvailable(auth()->user()->id)) return 'invalid';
            return response($blob->retriveImgCompressed())
            ->header( 'Content-Disposition', 'inline; filename="Knocks')
            ->header('Content-Type', $blob->extension);


        }
    }
    //retriveCover

    public function quote(Request $request){
        $blob =  Blob::find($request->id);
         if($blob == null) return 'invalid'; else {
            if($blob->type != 'image') return 'invalid';
            $parent = obj::find($blob->parent_object);
            if($parent == null) return 'invalid';
            if(!$parent->isAvailable(auth()->user()->id)) return 'invalid';
            return $blob->index()->quote;
        }

    }
}
