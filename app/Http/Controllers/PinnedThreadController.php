<?php

namespace App\Http\Controllers;

use App\Thread;

class PinnedThreadController extends Controller
{
    public function store(Thread $thread)
    {
        $thread->update(['pinned'=>true]);
    }

    public function destroy(Thread $thread)
    {
        $thread->update(['pinned'=>false]);
    }
}
