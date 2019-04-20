<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Reputation;

class ReputationsTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A Points test example.
     *
     * @return void
     */
    
    /** @test */
    public function user_awarded_points_on_creating_threads()
    {  
        $thread=create('App\Thread');
        $this->assertEquals(Reputation::Thread_Has_Published,$thread->creator->reputation);
    }
    
     /** @test */
    public function user_reduces_points_on_deleting_threads()
    {   
        $this->signIn();
        $thread=create('App\Thread',['user_id'=>auth()->id()]);
        $this->assertEquals(Reputation::Thread_Has_Published,$thread->creator->reputation);
        $this->delete($thread->path());
        $this->assertEquals(0,$thread->creator->fresh()->reputation);
    }
    
    /** @test */
    public function user_awarded_points_on_adding_reply()
    {
        $thread=create('App\Thread');
        $reply=$thread->addReply([
            'user_id'=>create('App\User')->id,
            'body'=>'i just like this thread'
        ]);
        $this->assertEquals(Reputation::Reply_Has_Made,$reply->owner->reputation);
    }
    
       /** @test */
    public function user_reduces_points_on_deleting_reply()
    {
        $this->signIn();
        $thread=create('App\Thread');
        $reply=$thread->addReply([
            'user_id'=>auth()->id(),
            'body'=>'i just like this thread'
        ]);
        $this->assertEquals(Reputation::Reply_Has_Made,$reply->owner->reputation);
        $this->delete("/replies/{$reply->id}");
        $this->assertEquals(0,$reply->owner->fresh()->reputation);
    }
    
      /** @test */
    public function reply_owner_awarded_points_on_mark_as_best_reply()
    {
         $thread=create('App\Thread');
        $reply=$thread->addReply([
            'user_id'=>create('App\User')->id,
            'body'=>'i just like this thread'
        ]);
        $thread->markBestReply($reply);
        $total=Reputation::Reply_Marked_As_Best+Reputation::Reply_Has_Made;
        $this->assertEquals($total,$reply->owner->reputation);
    }
    
    /** @test */
    public function user_earn_points_when_their_reply_is_favorited()
    {
        $this->signIn();
        $thread=create('App\Thread');
        $reply=$thread->addReply([
            'user_id'=>auth()->id(),
            'body'=>'i just like this thread'
        ]);
        $this->get("/replies/{$reply->id}/favorites");
        $total=Reputation::Reply_Has_Made+Reputation::Reply_Has_Favorited;
        $this->assertEquals($total,$reply->owner->fresh()->reputation);
    }
    
       /** @test */
    public function user_reduces_points_when_their_reply_is_unfavorited()
    {
        $this->signIn();
        $thread=create('App\Thread');
        $reply=$thread->addReply([
            'user_id'=>auth()->id(),
            'body'=>'i just like this thread'
        ]);
        $this->get("/replies/{$reply->id}/favorites");
        $total=Reputation::Reply_Has_Made+Reputation::Reply_Has_Favorited;
        $this->assertEquals($total,$reply->owner->fresh()->reputation);
        
        $this->get("/replies/{$reply->id}/unfavorites");
        $total=Reputation::Reply_Has_Made+Reputation::Reply_Has_Favorited - Reputation::Reply_Has_Favorited ;
        $this->assertEquals($total,$reply->owner->fresh()->reputation);
        
    }
    
    
}
