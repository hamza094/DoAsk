<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubscribeThreadTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A subscribe thread test.
     *
     * @return void
     */
    
    /** @test */
    public function an_authenticated_user_subscribe_to_a_thread()
    {
        $this->signIn();
        $thread=create("App\Thread");
        $this->post($thread->path().'/subscriptions');
        $this->assertCount(1, $thread->subscription);
        
    }
    
     /** @test */
    public function an_authentic_user_unsubscribe_to_a_thread()
    {
          $this->signIn();
        $thread = create('App\Thread');
        $thread->subscribe();
        $this->delete($thread->path() . '/subscriptions');
        $this->assertCount(0, $thread->subscription);
        
    }

}
