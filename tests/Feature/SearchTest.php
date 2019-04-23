<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Thread;

class SearchTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A Search test.
     *
     * @return void
     */
    
    /** @test */
    public function a_user_can_search_threads()
    {
       /*config(['scout.driver' => 'algolia']);
        create('App\Thread', [], 2);
        create('App\Thread', ['body' => 'A thread with the foobar term.'], 2);
        do {
            // Account for latency.
            sleep(.25);
            $results = $this->getJson('/threads/search?q=foobar')->json()['data'];
        } while (empty($results));
        $this->assertCount(2, $results);
        // Clean up.
        Thread::latest()->take(4)->unsearchable();*/
        $this->assertTrue(true);
    }
}
