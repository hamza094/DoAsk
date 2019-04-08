<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;


class ProfilesTest extends TestCase
{
    use RefreshDatabase;
   
    /**
     * A test for user profile.
     *
     * 
     */
    
    /** @test */
    public function a_user_has_a_profile()
    {
        $user=create('App\User');
        //verification required
        $this->get("/profiles/{$user->name}")
            ->assertDontSee($user->name);
    }
    
      /** @test */
    public function profiles_display_all_threads_created_by_associated_user()
    {
        $this->signIn();
        
        $thread=create('App\Thread',['user_id'=>auth()->id()]);
        
        $this->get("/profiles/".auth()->user()->name)
         ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
}
