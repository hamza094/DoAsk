<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Inspections\Spam;

class SpamTest extends TestCase
{
    /**
     * A spam test.
     *
     * @return void
     */
    
    /** @test */
    public function it_checks_for_invalid_keydown()
    {
        $spam=new Spam();
        $this->assertFalse($spam->detect('innocent reply here'));
        $this->expectException('Exception');
        $spam->detect('yahoo customer support');
        
    }
    
       /** @test */
    public function it_checks_for_any_key_being_held_down()
    {
        $spam=new Spam();
        $this->expectException('Exception');
        $spam->detect('Hello World aaaaaaaaa');
        
    }
}
