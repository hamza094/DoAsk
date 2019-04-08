<?php

namespace App\Policies;

use App\User;
use App\Reply;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReplyPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    
     public function update(User $user, Reply $reply)
    {
        return $reply->user_id == $user->id;
    }
    
    public function create(User $user){
         if (! $lastReply = $user->fresh()->lastReply) {
            return true;
        }
        return ! $lastReply->wasJustPublished();
    }
}
