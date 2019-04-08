<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;

class UsersTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A user test.
     *
     * @return void
     */
    
    /** @test */
    public function a_user_can_fetch_there_last_reply()
    {
        $user=create('App\User');
        $reply=create('App\Reply',['user_id'=>$user->id]);
        $this->assertEquals($reply->id,$user->lastReply->id);
    }
    
      /** @test */
    public function if_know_it_was_just_published(){
        $reply=create('App\Reply');
        $this->assertTrue($reply->wasJustPublished());
        $reply->created_at=Carbon::now()->subMonth();
        $this->assertFalse($reply->wasJustPublished());

    }
    
    /** @test */
    public function a_user_can_determine_their_avatar_path(){
         $user = create('App\User');
        $this->assertEquals(asset('/storage/'.'avatars/default.png'), $user->avatar_path);
        $user->avatar_path = 'avatars/me.jpg';
        $this->assertEquals(asset('/storage/'.'avatars/me.jpg'), $user->avatar_path);
    }
}
