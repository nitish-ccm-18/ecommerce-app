<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use App\Models\User;
use Gate;
use Auth;


class ProfileController extends Controller
{
    public function my_profile() {

        if(Gate::allows('my-profile')) {
            $profile = User::with('profile')
                ->where('id', $id = Auth::id())
                ->get();
            return view('profile.my-profile',['profile'=>$profile]);
        }
        abort(403);
    }

    public function user_profile($id) {
        if(Gate::allows('user-profile')) {
            $profile = User::with('profile')
                ->where('id', $id = Auth::id())
                ->get();
            return view('profile.user-profile',['profile'=>$profile]);
        }
        abort(403);
    }

    public function update(Request $request) {
        if(Gate::allows('my-profile')) {
            $user = User::find(Auth::id());
            $user->name = $request->name;
            $user->profile->gender = $request->gender;
            $user->profile->phone = $request->phone;
            $user->profile->occupation = $request->occupation;
            $user->profile->address = $request->address;
    
    
            if($request->file('avatar')) {
                $image = $user->profile->avatar;
    
                if(file_exists(public_path().'/public/Image/Users/'.$image) && $image){
                    unlink(public_path().'/public/Image/Users/'.$image);
                }
    
                $file= $request->file('avatar');
                $filename= time().$file->getClientOriginalName();
                $file-> move(public_path('public/Image/Users'), $filename);
    
                $user->profile->avatar = $filename;
            }
            $user->save();
            Alert('Profile Updated','Profile Updated successfully.');
            return back();
        }
        abort(403); 
    }
}
