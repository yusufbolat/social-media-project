<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function getProfile($username){
        
        $user = User::where('username', $username)->first();

        if(!$user){
            abort(404);
        }

        $statuses = $user->statuses()->notReply()->orderBy('created_at', 'desc')->get();
        
        return view('profile.index')->with('user', $user)->with('statuses', $statuses)->with('authUserIsFriend', !Auth::check() ? : Auth::user()->isFriendsWith($user));
    }

    public function getEdit(){
        return view('profile.edit');
    }

    public function postEdit(Request $request){
        $this->validate($request, [
            'first_name' => 'nullable|alpha|max:25',
            'last_name' => 'nullable|alpha|max:25',
            'location' => 'max:25',
        ]);

        Auth::user()->update([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'location' => $request->input('location'),
        ]);

        return redirect()
        ->route('profile.edit')
        ->with('info', 'Your profile has been updated successfully.');
    }
}
