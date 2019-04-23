<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A Admin test .
     *
     * @return void
     */
    
    public function setUp(){
        parent::setUp();
        $this->withExceptionHandling();
    }
    
    /** @test */
    public function only_admin_can_access_dashboard()
    {
        $admin=create('App\User');
        config(['forum.adminstrators'=>[$admin->email]]);
        $this->signIn($admin)
            ->get(route('admin.dashboard'))
            ->assertStatus(Response::HTTP_OK);
    }
    
       /** @test */
    public function non_admin_can_not_access_dashboard()
    {
        $user=create('App\User');
             $this->signIn($user)
            ->get(route('admin.dashboard'))
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }
}
