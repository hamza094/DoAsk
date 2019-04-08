<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Redis;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Trending;

class TrendingThreadsTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A trending test.
     *
     * @return void
     */
    
    protected function setup(){
        parent::setUp();
        $this->trending=new Trending();
        Redis::del($this->trending->cacheKey());
    }
    
    /** @test */
    public function it_increments_a_threads_score_each_time_it_is_read()
    {
        $this->assertEmpty($this->trending->get());
        $thread=create('App\Thread');
        $this->call('GET',$thread->path());
        $trending=$this->trending->get();
        $this->assertCount(1,$trending);
        $this->assertEquals($thread->title,$trending[0]->title);
       }
}
