<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Thread;

class PinnedThreadsTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A PinnedThread test.
     *
     * @return void
     */
     /** @test **/
    public function an_non_admin_can_not_pinned_threads()
    {
        $user=create('App\User');
        $this->signIn($user)->withExceptionHandling();
        $thread = create('App\Thread', ['user_id' => auth()->id()]);
        $this->post(route('pinned-thread.store',$thread));
        $this->assertFalse(!! $thread->fresh()->pinned);
   }
    
    /** @test **/
    public function an_admin_can_pinned_any_thread()
    {
       $admin=create('App\User');
        config(['forum.adminstrators'=>[$admin->email]]);
        $this->signIn($admin);
        $thread = create('App\Thread', ['user_id' => auth()->id()]);
        $this->post(route('pinned-thread.store',$thread));
        $this->assertTrue(!! $thread->fresh()->pinned);
   }
    
      /** @test **/
    public function an_admin_can_unpinned_any_thread()
    {
       $admin=create('App\User');
        config(['forum.adminstrators'=>[$admin->email]]);
        $this->signIn($admin);
        $thread = create('App\Thread', ['user_id' => auth()->id()]);
        $this->delete(route('pinned-thread.destroy',$thread));
        $this->assertFalse(!! $thread->fresh()->pinned);
   }
    
    
    public function pinned_thread_are_listed_first()
    {
     $admin=create('App\User');
        config(['forum.adminstrators'=>[$admin->email]]);
        $this->signIn($admin);
         $threads = create(Thread::class, [], 3);
        $ids = $threads->pluck('id');
        
        $response_data = $this->getJson('/threads')->decodeResponseJson()['data'];
        
        $this->assertEquals($ids[0], $response_data[0]['id']);
        $this->assertEquals($ids[1], $response_data[1]['id']);
        $this->assertEquals($ids[2], $response_data[2]['id']);
        $this->post(route('pinned-threads.store', $pinned = $threads->last()));
        
        $response_data = $this->getJson('/threads')->decodeResponseJson()['data'];
        $this->assertEquals($pinned->id, $response_data[0]['id']);
        $this->assertEquals($ids[0], $response_data[1]['id']);
        $this->assertEquals($ids[1], $response_data[2]['id']);
    }
}
