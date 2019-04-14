<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Thread;
use App\Channel;
use App\Reply;
use App\Rules\SpamFree;
use Illuminate\Support\Facades\Gate;
use App\Http\Forms\CreatePostForm;
use App\Notifications\YouWereMentioned;

class ReplyController extends Controller
{
    
    public function __construct(){
        $this->middleware('auth',['except'=>'index']);
    }
    
    public function index($channelId,Thread $thread){
        return $thread->replies()->paginate(10);
    }
    
    public function store($channelId,Thread $thread,Request $request,CreatePostForm $form){
        
       if($thread->locked){
           return response('Thread is locked',422);
       }
        
     $reply=$thread->addReply([
          'body'=>request('body'),
           'user_id'=>auth()->id() 
        ]);
        
        if(request()->expectsJson()){
            return $reply->load('owner');
        }
    }
    
     public function update(Reply $reply)
     {
        $this->authorize('update',$reply);
         $this->validate(request(),['body'=>'required|spamfree']);
        $reply->update(request(['body']));
       }
    
    public function destroy(Reply $reply){
        
        $this->authorize('update',$reply);
        $reply->favorites()->delete();
         $reply->delete();
         if(request()->wantsJson()){
            return response(['status'=>'Reply deleted']);
        }
        return back();
    }
   
    
   
}