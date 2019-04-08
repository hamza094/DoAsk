<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateThreadTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A UpdateThread test.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->withExceptionHandling();
        $this->signIn();
    }
    
    /** @test */
    public function a_thread_require_a_body_title_to_be_updated(){
         $thread=create('App\Thread',['user_id'=>auth()->id()]);
         $this->patch($thread->path(),[
            'title'=>'Changed',
            ])->assertSessionHasErrors('body');
        
         $this->patch($thread->path(),[
            'body'=>'Changed body',
            ])->assertSessionHasErrors('title');
        
    }
    
    /** @test */
    public function unauthorize_user_may_not_update_thread(){
         $thread=create('App\Thread',['user_id'=>create('App\User')->id]);
        $this->patch($thread->path(),[
            'title'=>'Changed'
        ])->assertStatus(403);
    }
    
    /** @test */
    public function a_thread_can_be_updated_by_its_creator()
    {
        $thread=create('App\Thread',['user_id'=>auth()->id()]);
        $this->patch($thread->path(),[
            'title'=>'Changed',
            'body'=>'Changed body'
        ]);
        $this->assertEquals('Changed',$thread->fresh()->title);
        $this->assertEquals('Changed body',$thread->fresh()->body);
    }
}
