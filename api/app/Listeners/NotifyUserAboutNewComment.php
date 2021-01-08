<?php

namespace App\Listeners;

use App\Events\NewCommentCreatedEvent;
use App\Notifications\NewCommentNotification;

class NotifyUserAboutNewComment
{
    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle(NewCommentCreatedEvent $event)
    {
        $user = $event->thread->parent->user;
        if ($user->id != auth()->id()) {
            $user->notify(new NewCommentNotification($event->thread));
        }
    }
}
