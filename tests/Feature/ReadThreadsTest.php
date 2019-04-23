<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReadThreadsTest extends TestCase
{
    
    use RefreshDatabase;
    
    public function setup(){
        parent::setup();
        $this->thread=factory('App\Thread')->create();

    }
 
    /** @test */
    public function a_user_can_view_all_threads()
    {
        $response = $this->get('/threads')
            ->assertSee($this->thread->title);
    }
    
      /** @test */
    public function a_user_can_read_a_sigle_thread()
    {
       
        $response = $this->get($this->thread->path())
            ->assertSee($this->thread->body);
        }
    
    
     /** @test */
    public function a_user_can_filter_threads_according_to_a_channel()
    {
        $channel=create('App\Channel');
        $threadInChannel=create('App\Thread',['channel_id'=>$channel->id]);
        $threadNotInChannel=create('App\Thread');
        $this->get('/threads/'.$channel->slug)
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNotInChannel->title);
        }
    
       /** @test */
    public function a_user_can_filter_threads_according_to_unanswered()
    {
        $Unanswerdthread = create('App\Thread');
        $this->get('threads?unanswered=1')
        ->assertSee($Unanswerdthread->title);
        
      
    }
    
      /** @test */
    public function a_thread_can_according_to_a_user()
    {
        $this->signIn(create('App\User',['name'=>'JonDoe']));
        
        $JonDoeInThread=create('App\Thread',['user_id'=>auth()->id()]);
        
        $JonDoeNotInThread=create('App\Thread');
        
        $this->get('threads?by=JonDoe')
            ->assertSee($JonDoeInThread->title)
            ->assertDontSee($JonDoeNotInThread->title);
        
      
    }
    
    /** @test */
    public function a_user_can_filter_threads_according_to_a_popularity()
    {
        $threadWithTwoReplies = create('App\Thread');
        create('App\Reply', ['thread_id' => $threadWithTwoReplies->id], 2);
        $threadWithThreeReplies = create('App\Thread');
        create('App\Reply', ['thread_id' => $threadWithThreeReplies->id], 3);
        $threadWithNoReplies = $this->thread;
        $response = $this->get('threads?popular=1');
        $response->assertSeeInOrder([
        $threadWithThreeReplies->title,
        $threadWithTwoReplies->title,
        $threadWithNoReplies->title
        ]);
    }
        
    /** @test */
    public function a_user_can_request_all_replies_for_a_given_thread(){
        $thread = create('App\Thread');
        create('App\Reply', ['thread_id' => $thread->id], 2);
        $response = $this->getJson($thread->path() . '/replies')->json();
        $this->assertCount(2, $response['data']);
        $this->assertEquals(2, $response['total']);
    }
    /** @test */
    public function we_record_a_new_visit_each_time_the_thread_is_read(){
        $thread=create('App\Thread');
        $this->assertSame(0,$thread->visits);
        $this->call('GET',$thread->path());
        $this->assertEquals(1,$thread->fresh()->visits);
    }
  
 
}


