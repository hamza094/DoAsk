<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Thread;
use Illuminate\Http\Request;
use App\Http\Forms\CreatePostForm;

class ReplyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except'=>'index']);
    }

    public function index($channelId, Thread $thread)
    {
        return $thread->replies()->paginate(config('forum.pagination.perPage'));
    }

    public function store($channelId, Thread $thread, Request $request, CreatePostForm $form)
    {
        if ($thread->locked) {
            return response('Thread is locked', 422);
        }

        $reply = $thread->addReply([
          'body'=>request('body'),
           'user_id'=>auth()->id()
        ]);

        if (request()->expectsJson()) {
            return $reply->load('owner');
        }
    }

    public function update(Reply $reply)
    {
        $this->authorize('update', $reply);
        $this->validate(request(), ['body'=>'required|spamfree']);
        $reply->update(request(['body']));
    }

    public function destroy(Reply $reply)
    {
        $this->authorize('update', $reply);
        $reply->favorites()->delete();
        $reply->delete();
        if (request()->wantsJson()) {
            return response(['status'=>'Reply deleted']);
        }

        return back();
    }
}
