<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LockThreadsTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A lock test example.
     *
     * @return void
     */
    
   /** @test */
    public function non_administrator_may_not_lock_threads(){
        $this->withExceptionHandling();
        $this->signIn();
        $thread = create('App\Thread', ['user_id' => auth()->id(),'locked'=>false]);
        $this->post(route('locked-thread.store',$thread))->assertStatus(403);
        $this->assertFalse(!! $thread->fresh()->locked);
    }
    
     /** @test */
    public function administrator_lock_threads(){
        $this->signIn(factory('App\User')->states('administrator')->create());
        $thread = create('App\Thread', ['user_id' => auth()->id()]);
        $this->post(route('locked-thread.store',$thread));
        $this->assertTrue(!! $thread->fresh()->locked);
    }
    
      /** @test */
    public function administrator_unlock_threads(){
        $this->signIn(factory('App\User')->states('administrator')->create());
        $thread = create('App\Thread', ['user_id' => auth()->id()]);
        $this->delete(route('locked-thread.destroy',$thread));
        $this->assertFalse(!! $thread->fresh()->locked);
    }
    
    /** @test */
    public function locked_thread_not_allowed_to_add_new_reply()
    {
        $this->signIn();
        $thread=create('App\Thread',['locked'=>true]);
        $this->post($thread->path().'/replies',[
            'body'=>'Foobar',
            'user_id'=>create('App\User')->id
        ])->assertStatus(422);
    }
}
