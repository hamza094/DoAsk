<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UsersNotificationsTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A UsersNotificationTest example.
     *
     * @return void
     */
    
    /** @test */
    public function mentioned_user_in_a_reply_are_notified()
    {
        $john=create('App\User',['name'=>'JohnDoe']);
        $this->signIn($john);
        $jane=create('App\User',['name'=>'JaneDoe']);
        $thread=create('App\Thread');
        $reply=make('App\Reply',[
            'body'=>'@JaneDoe look at this.'
        ]);
        $this->json('post',$thread->path().'/replies',$reply->toArray());
        $this->assertCount(1,$jane->notifications);
    }
    
    /** @test */
     function it_can_fetch_all_mentioned_users_starting_with_the_given_characters(){
         create('App\User',['name'=>'johndoe']);
         create('App\User',['name'=>'johndoe2']);
         create('App\User',['name'=>'jandoe']);
         $results=$this->json('GET','/api/users',['name'=>'john']);
         $this->assertCount(2,$results->json());
   }
}
