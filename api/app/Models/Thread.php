<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Thread extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeParents(Builder $builder)
    {
        return $builder->whereNull('parent_id');
    }

    public function comments()
    {
        return $this->hasMany(Thread::class, 'parent_id', 'id')->latest();
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public function upVotedBy()
    {
        $votes = $this->votes()->where('type', 'UP_VOTE')->get();
        return $votes->map(function ($vote) {
            return $vote->user_id;
        });
    }

    public function downVotedBy()
    {
        $votes = $this->votes()->where('type', 'DOWN_VOTE')->get();
        return $votes->map(function ($vote) {
            return $vote->user_id;
        });
    }

    public function parent()
    {
        return $this->hasOne(Thread::class,'id' , 'parent_id');
    }

    public function getScoresAttribute()
    {
        $upVoteCount = $this->votes->where('type', 'UP_VOTE')->count();
        $downVoteCount = $this->votes->where('type', 'DOWN_VOTE')->count();
        return $upVoteCount - $downVoteCount;
    }


    public static function boot()
    {
        parent::boot();
        self::creating(function ($thread) {
            $thread->slug = Str::slug($thread->title) . '-' . Str::random(6);
        });
    }
}
