<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Thread;
use App\Channel;


class ThreadSubscriptionsController extends Controller
{
    // $this->middleware('auth');
    //$this->middleware('verified');
    public function store($channelId,Thread $thread){
        $thread->subscribe();
    }
    
    public function destroy($channelId,Thread $thread){
        $thread->unsubscribe();
    }
}
