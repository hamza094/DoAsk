<?php

namespace App\Http\Controllers;

use App\Reply;

class BestRepliesController extends Controller
{
    public function store(Reply $reply)
    {
        $this->authorize('update', $reply->thread);
        $reply->thread->markBestReply($reply);
    }
}
