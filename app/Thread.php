<?php

namespace App;

use Laravel\Scout\Searchable;
use App\Events\ThreadReceivedNewReply;
use App\Notifications\ThreadWasUpdated;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use RecordActivity, Searchable;

    protected $guarded = [];
    
    protected $casts=[
      'locked'=> 'boolean',
       'pinned'=>'boolean'
    ];

    protected $with = ['channel'];

    protected $appends = ['isSubscribedTo'];

    public function path()
    {
        return "/threads/{$this->channel->slug}/{$this->slug}";
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function addReply($reply)
    {
        $reply = $this->replies()->create($reply);

        event(new ThreadReceivedNewReply($reply));

        foreach ($this->subscription as $subscribe) {
            if ($subscribe->user_id != $reply->user_id) {
                $subscribe->user->notify(new ThreadWasUpdated($this, $reply));
            }
        }

        return $reply;
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public static function boot()
    {
        parent::boot();
        static::deleting(function ($thread) {
            $thread->replies->each->delete();
            $thread->channel->decrement('threads_count');
            Reputation::reduce($thread->creator, Reputation::Thread_Has_Published);
        });
        static::created(function ($thread) {
            $thread->update(['slug'=>$thread->title]);
            $thread->channel->increment('threads_count');
            Reputation::award($thread->creator, Reputation::Thread_Has_Published);
        });
    }

    public function subscribe($userId = null)
    {
        $this->subscription()->create([
            'user_id'=>$userId ?: auth()->id()
        ]);

        return $this;
    }

    public function unsubscribe($userId = null)
    {
        $this->subscription()->where('user_id', $userId ?: auth()->id())->delete();
    }

    public function subscription()
    {
        return $this->hasMany(ThreadSubscription::class);
    }

    public function getIsSubscribedToAttribute()
    {
        return  $this->subscription()
            ->where('user_id', auth()->id())
            ->exists();
    }

    public function hasUpdatedFor()
    {
        $key = sprintf('users.%s.visits.%s', auth()->id(), $this->id);

        return $this->updated_at > cache($key);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function setSlugAttribute($value)
    {
        $slug = str_slug($value);
        if (static::whereSlug($slug)->exists()) {
            $slug = "{$slug}-".$this->id;
        }

        $this->attributes['slug'] = $slug;
    }

    public function markBestReply(Reply $reply)
    {
        $this->update(['best_reply_id'=>$reply->id]);
        Reputation::award($reply->owner, Reputation::Reply_Marked_As_Best);
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        return $this->toArray() + ['path' => $this->path()];
    }
}
