<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class forumauthtest extends TestCase
{
     use RefreshDatabase;
    
    /**
     * A basic test example.
     *
     * @return void
     */
    
      /** @test */
    public function an_authenticated_user_not_participate_in_forum_threads()
    {
       $this->expectException('Illuminate\Auth\AuthenticationException');
        
             
        $this->post('threads/some-channel/1/replies',[]);
        
    }
    
     /** @test */
    public function an_authenticated_user_may_participate_in_forum_threads()
    {
        $this->be($user=factory('App\User')->create());
        
        $thread=factory('App\Thread')->create();
        
        $reply=factory('App\Reply')->create();
        
        $this->post($thread->path()."/replies",$reply->toArray());
        
        $this->assertDatabaseHas('replies',['body'=>$reply->body]);
        $this->assertEquals(1,$thread->fresh()->replies_count); 
    }
    
       /** @test */
    public function a_thread_requires_a_body()
    {
       $this->withExceptionHandling()->signIn();
        
        $thread=factory('App\Thread');
        
        $reply=factory('App\Reply',['body'=>null]);
        
        $this->post($thread->path()."/replies",$reply->toArray())
            ->assertSessionHasErrors('body');
      
    }
    
    
}
