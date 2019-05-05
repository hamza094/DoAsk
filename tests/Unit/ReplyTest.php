<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;


class ReplyTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A reply test.
     *
     * @return void
     */
    
    /** @test */
    public function it_has_owner()
    {
        $reply=factory('App\Reply')->create();
        $this->assertInstanceOf('App\User',$reply->owner);
    }
    
    /** @test */
    public function it_can_detect_all_mentioned_users_in_the_body(){
         $reply = create('App\Reply', [
            'body' => '@JaneDoe wants to talk to @JohnDoe'
        ]);
        $this->assertEquals(['JaneDoe', 'JohnDoe'], $reply->mentionedUsers());
    }
    
    /** @test */
    public function it_wraps_username_in_the_body_within_anchor_tag(){
          $reply = new \App\Reply([
            'body' => 'Hello @Jane-Doe'
        ]);
        $this->assertEquals(
        'Hello <a href="/profiles/Jane-Doe">@Jane-Doe</a>',
        $reply->body    
        );
    }
    
    /** @test */
    public function it_knows_if_it_is_best_reply(){
    $reply=create('App\Reply');
        $this->assertFalse($reply->isBest());
        $reply->thread->update(["best_reply_id"=>$reply->id]);
        $this->assertTrue($reply->fresh()->isBest());
    }
    
    
    /** @test */
    public function it_generates_the_correct_path_for_paginated_links(){
        $thread=create('App\Thread');
        $replies=create('App\Reply',['thread_id'=>$thread->id],3);
        config(['forum.pagination.perPage'=>1]);
        $this->assertEquals($thread->path().'?page=1#reply-1',$replies->first()->path());
        $this->assertEquals($thread->path().'?page=2#reply-2',$replies[1]->path());
        $this->assertEquals($thread->path().'?page=3#reply-3',$replies->last()->path());
    }
    
    
    
}
