<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ParticipationTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    
   /** @test */
  public function an_unathorize_user_cannot_delete_reply(){
      $this->withExceptionHandling();
      $reply=create('App\Reply');
      $this->delete("/replies/{$reply->id}")
          ->assertRedirect('threads');
      
      $this->signIn()
      ->delete("/replies/{$reply->id}")
          ->assertStatus(403);
          
      
  } 
    
       /** @test */
  public function athorize_user_delete_reply(){
    $this->signIn();
    $reply=create('App\Reply',['user_id'=>auth()->id()]);
    $this->delete("/replies/{$reply->id}")->assertStatus(302);
    $this->assertDatabaseMissing('replies',['id'=>$reply->id]);
    $this->assertEquals(0,$reply->thread->fresh()->replies_count);   
  } 
    
       /** @test */
  public function an_unathorize_user_cannot_update_reply(){
      $this->withExceptionHandling();
      $reply=create('App\Reply');
      $this->patch("/replies/{$reply->id}")
          ->assertRedirect('threads');
      
      $this->signIn()
      ->patch("/replies/{$reply->id}")
          ->assertStatus(403);      
  } 
    
       /** @test */
  public function athorize_user_update_reply(){
    $this->signIn();
    $reply=create('App\Reply',['user_id'=>auth()->id()]);
    $Updatedreply='You have changed';  
    $this->patch("/replies/{$reply->id}",['body'=>$Updatedreply]);
    $this->assertDatabaseHas('replies',['id'=>$reply->id,'body'=>$Updatedreply]);
  }  
    
     /** @test */
  public function replies_that_contain_spam_may_not_be_created(){
      $this->withExceptionHandling();
      $this->signIn();
      $thread=create('App\Thread');
       $reply=make('App\Reply',[
          'body'=>'Yahoo Customer Support' 
       ]);
      $this->json('post',$thread->path().'/replies',$reply->toArray())
          ->assertStatus(422);
  }
    
      /** @test */
    public function users_may_only_reply_a_maximum_of_once_per_minute()
    { 
        $this->withExceptionHandling();
        $this->signIn();
      $thread=create('App\Thread');
       $reply=make('App\Reply',[
          'body'=>'my simple rules' 
       ]);
      $this->post($thread->path().'/replies',$reply->toArray())
          ->assertStatus(200);
        
        $this->post($thread->path().'/replies',$reply->toArray())
          ->assertStatus(422);
        
    }
    
}
