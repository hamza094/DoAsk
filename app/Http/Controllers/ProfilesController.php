<?php

namespace App\Http\Controllers;

use App\User;
use App\Activity;
use Auth;
use Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Validator;
use Session;


class ProfilesController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
    }

    /**
     * Show the user's profile.
     *
     * @param  User $user
     * @return \Response
     */
    public function show(User $user)
    {
        return view('profile.show', [
            'profileUser' => $user,
           'activities'=>Activity::feed($user)
        ]);
        
    }
    
    
    public function update(Request $request,$user)
    {
         
    $users = Auth::user();
    $users->name = Request::input('name');
    $users->email = Request::input('email');
    $users->username = Request::input('username');
        
    if ( ! Request::input('password') == '')
    {
        $users->password = Hash::make(Request::input('password'));
    }

    $users->save();
    return redirect(route('profile',['username'=>$users->username]))
        ->with('flash', 'Profile Updated Successfully');

    }
}



