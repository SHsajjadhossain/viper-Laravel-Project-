<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

class ProfileController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        return view('profile');
    }

    public function namechange (Request $request){
        $request->validate([
            'name' => 'required'
        ]);
        User::find(Auth::id())->update([
            'name' => $request->name
        ]);
        return back()->with('success', 'Your Name Changed Successfully');
    }
    public function passwordchange(Request $request){
        $request->validate([
            '*' => 'required|min:8'
        ]);

        if (Hash::check($request->old_password, Auth::user()->password)) {
            if ($request->password == $request->password_confirm) {
                User::find(Auth::id())->update([
                    'password' => bcrypt($request->password)
                ]);
                return back()->with('success_pass', 'Password Changed Successfully');
            }
            else {
                return back()->withErrors('Password Does not Match');
            }
        }
        else {
            return back()->withErrors('Password Does not Match');
        }
    }

    public function photochange (Request $request){
        $request->validate([
            'new_profile_photo' => 'required|image'
        ]);
        if (Auth::user()->profile_photo != 'default.jpg'){
            unlink(base_path('public/uploads/profile_photoes/'.Auth::user()->profile_photo));
        }
        $new_profile_photo_name = time().'_'.Str::random(10).'_'.Auth::id().'.'.$request->file('new_profile_photo')->getClientOriginalExtension();
            Image::make($request->file('new_profile_photo'))->resize(300, 300)->save(base_path('public/uploads/profile_photoes/'.$new_profile_photo_name));
            User::find(Auth::id())->update([
                'profile_photo' => $new_profile_photo_name
            ]);
            return back()->with('photo_success', 'Photo Changed Successfully!!');
    }
}


