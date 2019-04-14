<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ChannelsTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A channels test example.
     *
     * @return void
     */
    
    /** @test */
    public function a_user_can_browse_all_channel()
    {
        $this->signIn();
        $channel=create('App\Channel');
        $response=$this->get('/channels')
         ->assertSee($channel->title);
    }
    
    /** @test */
    public function an_user_can_add_channel(){
        $this->signIn();
        $channel=create('App\Channel');
        $this->post('/channels',$channel->toArray())
            ->assertStatus(200);
    }
    
    /** @test */
    public function channel_requires_a_name(){
        $this->withExceptionHandling()->signIn();
        $channel=make('App\Channel',[
            'name'=>null
        ]);
        $this->post('/channels',$channel->toArray())
            ->assertSessionHasErrors('name');
        }
    
    /** @test */
    public function a_user_can_delete_channel(){
        $this->withExceptionHandling()->signIn();
        $channel=create('App\Channel');
        $response=$this->json('DELETE',"/channels/{$channel->id}");
         $response->assertStatus(200);
        $this->assertDatabaseMissing('channels',['id'=>$channel->id]);
    }
    
    /** @test */
    public function a_user_can_update_channel(){
    $this->withExceptionHandling()->signIn();
    $channel=create('App\Channel');
    $Updatedchannel='You have changed';  
    $this->patch("/channels/{$channel->id}",['name'=>$Updatedchannel]);
    $this->assertDatabaseHas('channels',['id'=>$channel->id,'name'=>$Updatedchannel]);
    }
    
}
