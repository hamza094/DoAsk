<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Notifications\ReplyLiked;
use Auth;

class Reply extends Model
{
      use Notifiable;
    
    use RecordActivity;

    protected $guarded = [];
    protected $appends = ['favoritesCount', 'isFavorited', 'isBest','xp'];

    protected $with = ['owner', 'favorites'];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function favorites()
    {
        return $this->morphMany(Favourite::class, 'favorited');
    }

    public function favorite()
    {
        $attributes = ['user_id'=>auth()->id()];
        if (! $this->favorites()->where(['user_id'=>auth()->id()])->exists()) {
            $this->favorites()->create($attributes);
            if (auth()->user()->id != $this->user_id){
            $this->owner->notify(new ReplyLiked($this));
            }
        }
        
    }

    public function unfavorite()
    {
        $attributes = ['user_id'=>auth()->id()];
        $this->favorites()->where($attributes)->get()->each->delete();
    }

    public function isFavorited()
    {
        return (bool) $this->favorites->where('user_id', auth()->id())->count();
    }

    public function getisFavoritedAttribute()
    {
        return $this->isFavorited();
    }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }

    public function isBest()
    {
        return $this->thread->best_reply_id == $this->id;
    }

    public function getisBestAttribute()
    {
        return $this->isBest();
    }

    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    public function path()
    {
         $perPage = config('forum.pagination.perPage');
         $replyPosition = $this->thread->replies()->pluck('id')->search($this->id) + 1;
         $page = ceil($replyPosition / $perPage);
         return $this->thread->path()."?page={$page}#reply-{$this->id}";
    }

    public function wasJustPublished()
    {
        return $this->created_at->gt(Carbon::now()->subMinute());
    }

    public function mentionedUsers()
    {
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
    
      /**
     * Calculate the correct XP amount earned for the current reply.
     */
    public function getXpAttribute()
    {
        $xp = config('forum.reputation.reply_posted');
        if ($this->isBest()) {
            $xp += config('forum.reputation.best_reply_awarded');
        }
        return $xp += $this->favorites()->count() * config('council.reputation.reply_favorited');
    }

    public static function boot()
    {
        parent::boot();

        static::created(function ($reply) {
            $reply->thread->increment('replies_count');
            Reputation::award($reply->owner, Reputation::Reply_Has_Made);
        });

        static::deleting(function ($reply) {
            $reply->thread->decrement('replies_count');
            Reputation::reduce($reply->owner, Reputation::Reply_Has_Made);
        });

        static::deleting(function ($model) {
            $model->favorites->each->delete();
        });
    }
}
