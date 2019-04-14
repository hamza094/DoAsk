<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Channel extends Model
{

    protected $guarded=[];
    
    public function getRouteKeyName(){
        return 'slug';
    }
    
    public function threads(){
        return $this->hasMany(Thread::class);
    }
    
    public static function boot(){
        parent::boot();
       static::creating(function ($channel) {
        $channel->slug = Str::slug($channel->name);
    }); 
        
         static::deleting(function($channel){
            $channel->threads->each->delete();
        });
        
     }
    
    public function setSlugAttribute($value)
    {
      $slug=str_slug($value);
      if(static::whereSlug($slug)->exists()){
           $slug="{$slug}-".$this->id;
       }
        
        $this->attributes['slug'] = $slug;
    }
    
}


   