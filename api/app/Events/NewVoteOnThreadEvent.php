<?php

namespace App\Events;

use App\Models\Thread;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewVoteOnThreadEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Thread
     */
    public $count;
    public $thread_id;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($count, $thread_id)
    {
        $this->count = $count;
        $this->thread_id = $thread_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('thread-vote-count.' . $this->thread_id);
    }

    public function broadcastAs()
    {
        return 'on-vote-updated';
    }
}
