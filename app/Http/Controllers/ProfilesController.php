<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

use App\Activity;

class ProfilesController extends Controller
{
     public function __construct(){
        
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
}
