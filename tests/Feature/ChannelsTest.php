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
    public function a_admin_can_delete_channel(){
    $channel=create('App\Channel');
        $response=$this->json('DELETE',"/admin/channels/{$channel->id}");
        $response->assertStatus(200);
        $this->assertDatabaseMissing('channels',['id'=>$channel->id]);
    }
    
    /** @test */
    public function an_admin_can_update_channel(){
    $channel=create('App\Channel');
        $Updatedchannel='You have changed';
        $Updatedcolor='blue';
        $this->patch("/admin/channels/{$channel->id}",['name'=>$Updatedchannel,'archived'=>false,'color'=>$Updatedcolor]);
        $this->assertDatabaseHas('channels',['id'=>$channel->id,'name'=>$Updatedchannel]);
    }
    
    /** @test */
    public function a_admin_can_mark_existing_channel_as_archived(){
         $channel=create('App\Channel');  
        $this->assertFalse($channel->archived);
        $this->patch("/admin/channels/{$channel->id}",[
        'name'=>'altered',
        'color'=>'red',    
        'archived'=>true    
        ]);
        $this->assertTrue($channel->fresh()->archived);
    }
    
    /**@test */
    public function the_path_of_channel_is_uneffected_by_its_archived_status(){
        $thread=create('App\Thread');
        $path=$thread->path();
        $thread->channel->archive();
        $this->assertEquals($path,$thread->fresh()->path());
    }
    
}