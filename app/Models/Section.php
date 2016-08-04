<?php

namespace Forum\Models;

use AlgoliaSearch\Laravel\AlgoliaEloquentTrait;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use AlgoliaEloquentTrait;

    public static $autoIndex = true;
    public static $autoDelete = true;

    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    protected $dates = [
        'last_topic_at',
        'deleted_at',
    ];

    public function getLatestTopic($id)
    {
        if (auth()->user()) {
            if (auth()->user()->hasRole(['moderator', 'admin', 'owner'])) {
                return $this->findOrFail($id)->topics()->latestFirst()->first();
            }
        }

        return $this->findOrFail($id)->topics()->isVisible()->latestFirst()->first();
    }

    public function topicCountText()
    {
        $count = $this->topicCount();

        if ($count == 1) {
            return number_format($count).' topic';
        }

        return number_format($count).' topics';
    }

    public function topicCount()
    {
        return $this->topics()->isVisible()->count();
    }

    public function topics()
    {
        return $this->hasMany(Topic::class);
    }
}
