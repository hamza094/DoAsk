<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Thread;
use App\Rules\Recaptcha;
use App\Channel;

class CreateThreadTest extends TestCase
{
   use RefreshDatabase;
    
       public function setUp()
    {
        parent::setUp();
        app()->singleton(Recaptcha::class, function () {
            return \Mockery::mock(Recaptcha::class, function ($m) {
                $m->shouldReceive('passes')->andReturn(true);
            });
        });
    }
    
      /** @test */
    public function guest_may_not_publish_threads()
    {
      $this->expectException('Illuminate\Auth\AuthenticationException');
            
        $thread=make('App\Thread');
                        
      $this->post('/threads',$thread->toArray());
    }
    
      /** @test */
    public function guest_cannot_see_the_create_thread_page()
    {
          $this->withExceptionHandling()
        ->get('/threads/create')
            ->assertRedirect('/threads');
        
    }
    
       /** @test */
    public function an_authenticated_user_may_publish_threads()
    {
        $this->signIn();
        $thread = make('App\Thread');
        $response = $this->post('/threads', $thread->toArray()+['g-recaptcha-response'=>'token']);
        $this->get($response->headers->get('Location'))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
    
    /** @test */
    public function a_thread_requires_a_title()
    {
        $this->publishThread(['title'=>null])
        ->assertSessionHasErrors('title');
    }
    
      /** @test */
    public function a_thread_requires_a_body()
    {
        $this->publishThread(['body'=>null])
        ->assertSessionHasErrors('body');
    }
    
       /** @test */
    public function a_thread_requires_a_unique_slug(){
        $this->signIn();
        create('App\Thread',[],2);
        $thread=create('App\Thread',['title'=>'Foo Title']);
        $this->assertEquals($thread->fresh()->slug,'foo-title');
    $thread=$this->postJson('/threads', $thread->toArray()+['g-recaptcha-response'=>'token'])->json();
    $this->assertEquals("foo-title-{$thread['id']}", $thread['slug']);

    }
    
     /** @test */
    function a_thread_with_a_title_that_ends_in_a_number_should_generate_the_proper_slug()
    {
          $this->signIn();
        $thread = create('App\Thread', ['title' => 'Some Title 24']);
        $thread = $this->postJson('/threads', $thread->toArray()+['g-recaptcha-response'=>'token'])->json();
        $this->assertEquals("some-title-24-{$thread['id']}", $thread['slug']);

    }

    
      /** @test */
    public function a_thread_requires_a_valid_channel()
    {
         factory('App\Channel',2)->create();
        
        $this->publishThread(['channel_id'=>null])
        ->assertSessionHasErrors('channel_id');
               
        $this->publishThread(['channel_id'=>999])
        ->assertSessionHasErrors('channel_id');
    }
    
    /** @test */ 
     public function a_new_thread_cannot_be_created_in_an_archived_channel(){
        $channel=create('App\Channel',['archived'=>true]);
        $this->publishThread(['channel_id'=>$channel->id])
            ->assertSessionHasErrors('channel_id');
        $this->assertCount(0,$channel->threads);
     }
    
    
           /** @test */
    public function an_unathorized_user_not_allow_to_delete_a_thread(){
        $this->withExceptionHandling();
        $thread=create('App\Thread');
        $response=$this->delete($thread->path())->assertRedirect('/threads');
        $this->signIn();
        $response=$this->delete($thread->path())->assertStatus(403);
       

    }
    
       /** @test */
    public function authorized_user_allow_to_delete_thread(){
        $this->signIn();
        $thread=create('App\Thread',['user_id'=>auth()->id()]);
        $reply=create('App\Reply',['thread_id'=>$thread->id]);
        $response=$this->json('DELETE',$thread->path());
        $response->assertStatus(204);
        $this->assertDatabaseMissing('threads',['id'=>$thread->id]);
        $this->assertDatabaseMissing('replies',['id'=>$reply->id]);

    }
    
    
       protected function publishThread($overrides = [])
    {
        $this->withExceptionHandling()->signIn();
        $thread = make('App\Thread', $overrides);
        return $this->post('/threads', $thread->toArray());
    }
    
    /** @test */
    public function a_thread_requires_recaptcha_verification(){
        unset(app()[Recaptcha::class]);
        $this->publishThread(['g-recaptcha-response'=>'test'])
        ->assertSessionHasErrors('g-recaptcha-response');
        
    }
    
     
       
}

