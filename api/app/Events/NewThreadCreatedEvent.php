<?php

namespace App\Events;

use App\Models\Thread;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewThreadCreatedEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Thread $thread;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Thread $thread)
    {
        $this->thread = $thread;
    }

    public function broadcastOn()
    {
        return new Channel('threads');
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->thread->id,
            'title' => $this->thread->title,
            'scores' => (int)$this->thread->scores,
            'upVotedBy' => [auth()->id()],
            'downVotedBy' => $this->thread->downVotedBy(),
            'slug' => $this->thread->slug,
            'is_link' => $this->thread->is_link,
            'link' => $this->thread->link,
            'body' => $this->thread->body,
            'user' => $this->thread->user,
            'comments_count' => $this->thread->comments_count,
            'thumbnail' => $this->thread->thumbnail,
            'time' => $this->thread->created_at->diffForHumans()
        ];
    }

    public function broadcastAs()
    {
        return 'on-new-thread-created';
    }
}
