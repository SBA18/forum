<?php

namespace Forum;

use Forum\User;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'slug',
        'body',
    ];

    public function scopeLatestFirst($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * Get the user that owns the topic.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}