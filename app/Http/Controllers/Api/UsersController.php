<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class ChannelsController extends Controller
{
    public function index(){
        $search=request('name');
        return User::where('name','LIKE',"$search%")
            ->take(5)
            ->pluck('name');
    }
}
