<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FavouritesTest extends TestCase
{
    use RefreshDatabase;
    
       /** @test */
    public function guest_cannot_favourite_anything()
    {
        $this->withExceptionHandling()
            ->get('replies/1/favorites')
            ->assertRedirect('/threads');
        
    }
    
       
       /** @test */
    public function an_authenicate_user_can_favourite_anything()
    {
        $this->signIn();
        $reply=create('App\Reply');
        
        $this->get('replies/' . $reply->id . '/favorites');
        $this->assertCount(1,$reply->favorites);
    }
    
        /** @test */
    public function an_authenicate_user_can_favourite_a_reply_once()
    {
        $this->signIn();
        $reply=create('App\Reply');
        
        try{
        $this->get('replies/' . $reply->id . '/favorites');
        $this->get('replies/' . $reply->id . '/favorites');
        }catch(\Exception $e){
            $this->fail('Did not allow to like twice');
        }
        $this->assertCount(1,$reply->favorites);
    }
    
         /** @test */
    public function an_authenicate_user_can_unfavourite_reply()
    {
        $this->signIn();
        $reply=create('App\Reply');
        
        $this->get('replies/' . $reply->id . '/favorites');
        
        $this->assertCount(1,$reply->favorites);
        
         $this->get('replies/' . $reply->id . '/unfavorites');
        
        $this->assertCount(0,$reply->fresh()->favorites);

        
    }
}
