<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Reputation;

class FavoritesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
    }

    public function store(Reply $reply)
    {
        $reply->favorite();
        $reply->owner->increment('reputation', Reputation::Reply_Has_Favorited);
        

        return back();
    }

    public function destroy(Reply $reply)
    {
        $reply->unfavorite();
        $reply->owner->decrement('reputation', Reputation::Reply_Has_Favorited);
    }
}
