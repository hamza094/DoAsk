<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class Reply extends Model
{
    use RecordActivity;
    
        protected $guarded=[];
    protected $appends=['favoritesCount','isFavorited','isBest'];

    protected $with=['owner','favorites'];
    
    public function owner(){
        return $this->belongsTo(User::class,'user_id');
    }
    
    public function favorites(){
        return $this->morphMany(Favourite::class,'favorited');
    }
    
    public function favorite(){
        $attributes=['user_id'=>auth()->id()];
        if(!$this->favorites()->where(['user_id'=>auth()->id()])->exists()){
            $this->favorites()->create($attributes);
        }
                

    }
    
       public function unfavorite(){
        $attributes=['user_id'=>auth()->id()];
       $this->favorites()->where($attributes)->get()->each->delete();
                

    }
    
    public function isFavorited(){
         return !! $this->favorites->where('user_id',auth()->id())->count();
    }
    public function getisFavoritedAttribute(){
        return $this->isFavorited();
    }
    
    
     public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }
    
    public function isBest(){
         return $this->thread->best_reply_id==$this->id;
    }
    public function getisBestAttribute(){
        return $this->isBest();
    }
    
    public function thread(){
        return $this->belongsTo(Thread::class);
    }
    public function path(){
        return $this->thread->path()."#reply-{$this->id}";
    }
    public function wasJustPublished(){
        return $this->created_at->gt(Carbon::now()->subMinute());
    }
    
    public function mentionedUsers(){
      preg_match_all('/@([\w\-]+)/', $this->body, $matches);
        return $matches[1];
    }
    
     public function setBodyAttribute($body)
    {
    $this->attributes['body'] = preg_replace(
            '/@([\w\-]+)/',
            '<a href="/profiles/$1">$0</a>',
            $body
        );
    }
       public static function boot(){
           parent::boot();
           
            static::created(function($reply){
            $reply->thread->increment('replies_count');
        });
           
        static::deleting(function($reply){
        $reply->thread->decrement('replies_count');
        });   
           
       static::deleting(function($model){
            $model->favorites->each->delete();
        }); 
        
     }
    
    
       
}
