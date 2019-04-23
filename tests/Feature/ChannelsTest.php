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
    */
    
    public function setUp(){
        parent::setUp();
        
    $admin=create('App\User');
    config(['forum.adminstrators'=>[$admin->email]]);
    $this->withExceptionHandling()->signIn($admin);
        
    }
    
    /** @test */
    public function an_admin_can_browse_all_channel(){
    $channel=create('App\Channel');
        $response=$this->get('/admin/channels')
         ->assertSee($channel->title);
    }
    
    /** @test */
    public function an_admin_can_add_channel(){
    $channel=create('App\Channel');
        $this->post('/admin/channels',$channel->toArray())
            ->assertStatus(200);
    }
    
    /** @test */
    public function channel_requires_a_name(){
    $channel=make('App\Channel',[
            'name'=>null
        ]);
        $this->post('/admin/channels',$channel->toArray())
            ->assertSessionHasErrors('name');
    }
    
    /** @test */
    public function a_user_can_delete_channel(){
    $channel=create('App\Channel');
        $response=$this->json('DELETE',"/admin/channels/{$channel->id}");
        $response->assertStatus(200);
        $this->assertDatabaseMissing('channels',['id'=>$channel->id]);
    }
    
    /** @test */
    public function a_user_can_update_channel(){
    $channel=create('App\Channel');
        $Updatedchannel='You have changed';  
        $this->patch("/admin/channels/{$channel->id}",['name'=>$Updatedchannel]);
        $this->assertDatabaseHas('channels',['id'=>$channel->id,'name'=>$Updatedchannel]);
    }
    
}