<?php

namespace App;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    protected $guarded = [];

    protected $casts = [
       'archived'=>'boolean'
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function threads()
    {
        return $this->hasMany(Thread::class);
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function ($channel) {
            $channel->slug = Str::slug($channel->name);
        });

        static::deleting(function ($channel) {
            $channel->threads->each->delete();
        });

        static::addGlobalScope('active', function ($builder) {
            $builder->where('archived', false)
                ->orderBy('name', 'asc');
        });
    }

    public function setSlugAttribute($value)
    {
        $slug = str_slug($value);
        if (static::whereSlug($slug)->exists()) {
            $slug = "{$slug}-".$this->id;
        }

        $this->attributes['slug'] = $slug;
    }

    public function archive()
    {
        $this->update(['archived'=>true]);
    }

    public function getNameAttribute($value)
    {
        return ucwords($value);
    }
}
