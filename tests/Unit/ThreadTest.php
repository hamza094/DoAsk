<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Notifications\ThreadWasUpdated;
use Illuminate\Support\Facades\Notification;

class ThreadTest extends TestCase
{
    use RefreshDatabase;
    
     public function setup(){
        parent::setup();
        $this->thread=factory('App\Thread')->create();
    }
    
       /** @test */
    public function a_thread_can_make_a_string_path(){
        $thread=create('App\Thread');
        $this->assertEquals(
            "/threads/{$thread->channel->slug}/{$thread->slug}",$thread->path());
    }
    
    /**
     * A basic test example.
     *
     * @return void
     */
    
     /** @test */
    public function a_thread_has_replies()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection',$this->thread->replies);
    }
    
    /** @test */
    public function a_thread_has_a_creator()
    {
        $this->assertInstanceOf('App\User',$this->thread->creator);
    }
    
    /** @test */
    public function a_thread_can_add_a_reply()
    {
        $this->thread->addReply([
            'body'=>'Foobar',
            'user_id'=>1
        ]);
        
        $this->assertCount(1,$this->thread->replies);
    }
    
    /** @test */
    public function a_thread_notifies_all_registered_subscribers_when_a_reply_is_added(){
        Notification::fake();
        $this->signIn();
        $this->thread->subscribe();
         $this->thread->addReply([
            'body'=>'Foobar',
            'user_id'=>999
        ]);
        Notification::assertSentTo(auth()->user(), ThreadWasUpdated::class);
    }
    
    /** @test */
    public function a_thread_has_a_channel(){
        $this->assertInstanceOf('App\Channel',$this->thread->channel);
    } 
    
     /** @test */
    public function a_thread_can_be_subscribed_to(){
        $thread=create("App\Thread");
        $thread->subscribe($userId=1);
        $this->assertEquals(1,$thread->subscription()->where('user_id',$userId)->count());
        } 
    
  /** @test */
    public function a_thread_can_be_unsubscribed_from()
    {
        $thread = create('App\Thread');
        $thread->subscribe($userId = 1);
        $thread->unsubscribe($userId);
        $this->assertCount(0, $thread->subscription);
    }
    
     /** @test */
    public function authenticated_user_subscibed_to()
    {
        $thread = create('App\Thread');
      $this->signIn();
        $this->assertFalse($thread->isSubscribedTo);
        $thread->subscribe();
        $this->assertTrue($thread->isSubscribedTo);
        
   }
    
    /** @test */
    public function a_thread_can_check_if_the_authenticated_user_has_read_all_replies(){
        $this->signIn();
        $thread=create('App\Thread');
        $user=auth()->user();
        $this->assertTrue($thread->hasUpdatedFor($user));
        
          $this->thread->addReply([
            'body'=>'Foobar',
            'user_id'=>999
        ]);
        $key=sprintf("users.%s.visits.%s",$user,$thread->id);
        cache()->forever($key,\Carbon\Carbon::now());
        $this->assertFalse($thread->hasUpdatedFor($user));
   }
    
    /** @test */
    public function unverified_user_can_not_see_alert_message(){
        $null='null';
        $user=create('App\User',[
           'email_verified_at'=>'2019-03-23 15:21:36'
        ]);
        $this->signIn($user);
        $this->get("/threads")->assertDontSee("<div class='alert alert-danger' role='alert'>
       <p class='text-center'><b>Important Notice!</b> Email <a href='/home'>confirmation</a> required</p>
   </div>");
    }
    
 
    
}
