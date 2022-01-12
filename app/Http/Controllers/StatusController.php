<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use App\Models\Status;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function postStatus(Request $request){

        $this->validate($request, [
            'status' => 'required|max:250',
            'image' => 'image|dimensions:min_width=735,min_height=400',
        ]);

        if($request->hasFile('image')){
            
            $imageName = time().'-'.Auth::user()->username.'.'.$request->image->extension();
            $request->image->storeAs('images', $imageName, 'public');
            Auth::user()->statuses()->create([
                'body' => $request->input('status'),
                'img_url' => $imageName,
            ]);
        }
        else{
            Auth::user()->statuses()->create([
                'body' => $request->input('status'),
            ]);
        }

        return redirect()
            ->route('home')
            ->with('info', 'Status posted');
    }

    public function postReply(Request $request, $statusId){

        $this->validate($request, [
            "reply-{$statusId}" => 'required|max:150', 
        ]);

        $status = Status::notReply()->find($statusId);

        if(!$status){
            return redirect()->route('home');
        }

        if(!Auth::user()->isFriendsWith($status->user) && Auth::user()->id !== $status->user->id){
            return redirect()->route('home');
        }

        $reply = Status::create([
            'body' => $request->input("reply-{$statusId}"),
        ])->user()->associate(Auth::user());

        $status->replies()->save($reply);

        return redirect()->back();
    }

    public function getLike($statusId){

        $status = Status::find($statusId);

        if(!$status){
            return redirect()->route('home');
        }

        if(!Auth::user()->isFriendsWith($status->user) && Auth::user()->id !== $status->user->id){
            return redirect()->route('home');
        }

        if(Auth::user()->hasLikedStatus($status)){
            $status->likes->where('user_id', Auth::user()->id)->each->delete();
            return redirect()->back();
        }

        $like = $status->likes()->create([]);
        Auth::user()->likes()->save($like);

        return redirect()->back();
    }
}
