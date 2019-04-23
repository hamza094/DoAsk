<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail 
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','avatar_path'
    ];
    
     public function getRouteKeyName(){
        return 'name';
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','email'
    ];
    
    public function threads(){
        return $this->hasMany(Thread::class)->latest();
    }
    
    public function activities(){
        return $this->hasMany(Activity::class);
    }
    public function lastReply(){
        return $this->hasOne(Reply::class)->latest();
    }
    public function getAvatarPathAttribute($avatar){
        return asset('/storage/'.($avatar ?: 'avatars/default.png'));
    }
    public function isAdmin(){
        return in_array($this->email, config('forum.adminstrators'));
    }
}
