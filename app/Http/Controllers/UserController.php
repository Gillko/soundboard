<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use Auth;
use Image;

class UserController extends Controller
{
	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show(){
    	return view('profile', ['user' => Auth::user()]);
	}

	public function update(User $user, Request $request){
        $user = Auth::user();
        $user->firstname = $request->get('firstname');
        $user->surname = $request->get('surname');
        $user->nickname = $request->get('nickname');
        $user->email = $request->get('email');
        if($request->hasFile('avatar')){
            $avatar = $request->file('avatar');
            
            $user = Auth::user();

            //===deleting the old File===//
            $oldFile = $user->avatar;

            if(file_exists(public_path('/uploads/avatars/' . $user->firstname . '-' . $user->surname . '-' . $user->email .'/' . $oldFile))){
                unlink(public_path('/uploads/avatars/' . $user->firstname . '-' . $user->surname . '-' . $user->email .'/' . $oldFile));
            }
            //===deleting the old File===//

           	$filename = 'avatar-' . time() . '-' . $user->firstname . '-' . $user->surname . '-' . $user->nickname . '.' . $avatar->getClientOriginalExtension();
            //Image::make($avatar)->save( public_path('/uploads/avatars/' . $filename ));

            $location = (public_path('/uploads/avatars/' . $user->firstname . '-' . $user->surname . '-' . $user->email ));

            $avatar->move($location,$filename);

            $user->avatar = $filename;
        }
        $user->save();
        return view('profile', ['user' => Auth::user()]);
    }
}