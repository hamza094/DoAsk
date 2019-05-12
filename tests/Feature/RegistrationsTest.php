<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Support\Facades\Mail;

class RegistrationsTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A registration test.
     *
     * @return void
     */
    
     public function setUp() {
        parent::setUp();
        Mail::fake();
    }
    
    public function a_confirmation_email_is_sent_upon_registration()
    {
        $this->post(route('register'), $this->validParams());
        Mail::assertQueued(VerifiesEmails::class);
    }
    
      
    /** @test */
    public function a_user_can_register_account()
    {
        $response=$this->post(route('register'),[
            'name'=>'John Doe',
            'username'=>'johndoe',
            'email'=>'john_thanos@live.com',
            'password'=>'secret',
            'password_confirmation'=>'secret'
        ]);
        $response->assertRedirect('/home');
        $this->assertTrue(Auth::check());
        $this->assertCount(1,User::all());
        tap(User::first(),function($user){
            $this->assertEquals('John Doe',$user->name);
            $this->assertEquals('johndoe',$user->username);
            $this->assertEquals('john_thanos@live.com',$user->email);
            $this->assertTrue(Hash::check('secret', $user->password));
        });
    }
    
    /** @test */
    public function name_username_email_password_is_required(){
        $this->withExceptionHandling();
        $this->post(route('register'));
        $response=$this->post(route('register'),$this->validParams([
            'name'=>'',
            'username'=>'',
            'email'=>'',
            'password'=>''
        ]));
        $response->assertSessionHasErrors('name');
        $response->assertSessionHasErrors('username');
        $response->assertSessionHasErrors('email');
        $response->assertSessionHasErrors('password');
        $this->assertFalse(Auth::check());
        $this->assertCount(0,User::all());
    }
    
    /** @test */
    public function name_username_email_validation_check(){
                $this->withExceptionHandling();
        $this->post(route('register'));
        $response=$this->post(route('register'),$this->validParams([
            'name'=>str_repeat('a', 256),
            'username'=>'spaces and symbols!',
            'email'=>'not-an-email-address',
             'password' => 'foo',
            'password_confirmation' => 'bar'
        ]));
        $response->assertSessionHasErrors('name');
        $response->assertSessionHasErrors('username');
        $response->assertSessionHasErrors('email');
        $response->assertSessionHasErrors('password');
        $this->assertFalse(Auth::check());
        $this->assertCount(0,User::all());
    }
    
      /** @test */
    public function email_and_username_is_unique(){
        create('App\User',['username'=>'john','email'=>'johndoe@example.com']);
                $this->withExceptionHandling();
        $this->post(route('register'));
        $response=$this->post(route('register'),$this->validParams([
            'username'=>'john',
            'email'=>'johndoe@example.com'
         
        ]));
        $response->assertSessionHasErrors('username');
        $this->assertFalse(Auth::check());
        $this->assertCount(1,User::all());
    }
    
    private function validParams($overrides = []) {
        return array_merge([
            'name' => 'John Doe',
            'username' => 'johndoe',
            'email' => 'johndoe@example.com',
            'password' => 'secret',
            'password_confirmation' => 'secret',
        ], $overrides);
    }
    
}
