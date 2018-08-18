<?php

namespace ICTDUInventory\Http\Controllers;

use Illuminate\Http\Request;
use ICTDUInventory\User;
use Session;
use Auth;
use Image;
use Storage;
use Hash;

class UserController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function viewUser()
    {
    	return view('users.settings');
    }

    public function updatePicture(Request $request)
    {
        $this->validate($request, [
        	'profile_picture'          =>        'required|image'
        ]);

        $id = Auth::user()->id;
        $user = User::find($id);

        //save image
            if($request->hasFile('profile_picture')){
                $image = $request->file('profile_picture');
                $filename = $id . '.' . time() . '.' . $image->getClientOriginalExtension();
                $location = public_path('images/' . $filename);
                Image::make($image)->save($location);
                $oldImage = $user->image; //old imagename

                $user->image = $filename; 

                Storage::delete($oldImage); //delete old image
             
            }

        $user->save();

        Session::flash('picture-is-in', 'value');
        Session::flash('success', 'Your profile picture has been successfully changed.');

        return redirect()->route('view.user');
    }

    public function updateInfo(Request $request)
    {
    	if ($request->email == Auth::user()->email) {
    		$this->validate($request, [
    			'name'             =>          'required|min:3|max:50'
    		]);
    	}
    	else {
    		$this->validate($request, [
    			'name'             =>          'required|max:50',
    			'email'            =>          'required|email'
    		]);
    	}

    	$id = Auth::user()->id;
    	$user = User::find($id);

    	$user->name = $request->name;
    	$user->email = $request->email;

    	$user->save();

    	Session::flash('info-is-in','value');
    	Session::flash('success', 'Your info has been successfully changed.');

    	return redirect()->route('view.user');
    }

    public function updatePassword(Request $request, $id)
    {
    	$this->validate($request, [
    		'old_password'         =>       'required',
            'new_password'     =>           'required|string|min:6|confirmed'          
    	]);

    	if (Hash::check($request->old_password, Auth::user()->password)) {
    		//if current password and new password are same
    		if(strcmp($request->get('old_password'), $request->get('new_password')) == 0) {
    			Session::flash('password-is-in', 'haha');
    			Session::flash('error', 'New Password cannot be same as your current password. Please choose a different password.');
                return redirect()->route('view.user');
    		}

    		$user = User::find($id);

    		$user->password = bcrypt($request->new_password);

    		$user->save();

    		Session::flash('password-is-in', 'haha');
    		Session::flash('success', 'Your password has been successfully changed.');
            return redirect()->route('view.user');

    	}
    	else {
    		Session::flash('password-is-in', 'haha');
    		Session::flash('error', 'The old password you provided did not match your current password.');
            return redirect()->route('view.user');
    	}

    }

}
