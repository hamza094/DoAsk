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
        $this->get("/profiles/{$user->username}")
            ->assertDontSee($user->username);
    }
    
      /** @test */
    public function profiles_display_all_threads_created_by_associated_user()
    {
        $this->signIn();
        
        $thread=create('App\Thread',['user_id'=>auth()->id()]);
        
        $this->get("/profiles/".auth()->user()->username)
         ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
    
    /** @test */
    public function an_authenicate_user_update_his_profile()
    {
        $user=create('App\User',['id'=>auth()->id()]);
        $this->withExceptionHandling()->signIn($user);
        $this->patch("/profile/{$user->id}",[
           'name'=>'aslam raza',
            'email'=>'aslam_pisces@live.com',
            'username'=>'aslam.raza'
        ]);
        $this->assertDatabaseHas('users',['id'=>$user->id,'name'=>'aslam raza','email'=>'aslam_pisces@live.com','username'=>'aslam.raza']);
    }
    
}
