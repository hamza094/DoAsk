<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Notifications\DatabaseNotification;

class NotificationsTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A notifications test.
     *
     * @return void
     */
    
      /** @test */
    public function a_notification_is_prepared_when_a_subscribed_thread_receives_a_new_reply_that_is_not_by_the_current_user(){
        $this->signIn();
        $thread=create("App\Thread")->subscribe();
        $this->assertCount(0, auth()->user()->notifications);
        $thread->addReply([
            'user_id'=>auth()->id(),
            'body'=>"some reply here"
        ]);
        $this->assertCount(0,auth()->user()->notifications);
        
         $thread->addReply([
            'user_id'=>create('App\User')->id,
            'body'=>"some reply here"
        ]);
        $this->assertCount(1,auth()->user()->fresh()->notifications);
    }
    
     
    public function a_user_can_mark_a_notification_as_read(){
           $this->signIn();
        $thread=create("App\Thread")->subscribe();
        $thread->addReply([
            'user_id'=>auth()->id(),
            'body'=>"some reply here"
        ]);
        $user=auth()->user();
        $this->assertCount(1,$user->unreadNotifications);
        $notificationId=$user->unreadNotifications->first()->id;
        $this->delete("/profiles/{$user->name}/notifications/{$notificationId}");
       $this->assertCount(0, $user->fresh()->unreadNotifications);
        
        
        
        
    }
    
        
    function a_user_can_fetch_their_unread_notifications()
    {
        
       create(DatabaseNotification::class);
        $this->assertCount(
            1,
            $this->getJson("/profiles/" . auth()->user()->name . "/notifications")->json()
        );
    }
}
