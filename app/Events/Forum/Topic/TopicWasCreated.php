<?php

namespace Forum\Events\Forum\Topic;

use Forum\Events\Event;
use Forum\Models\Topic;
use Forum\Models\Section;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class TopicWasCreated extends Event
{
    use SerializesModels;

    public $topic;
    public $section;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Topic $topic, Section $section)
    {
        $this->topic = $topic;
        $this->section = $section;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
