<?php

namespace App\Listeners;

/**
 * Class UpvoteMyOwnThreadListener
 * @package App\Listeners
 */
class UpvoteMyOwnThread
{

    public function handle($event)
    {
        auth()->user()->votes()->create([
            'type' => 'UP_VOTE',
            'thread_id' => $event->thread->id
        ]);
    }
}
