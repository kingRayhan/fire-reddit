<?php

namespace App\Providers;

use App\Events\NewCommentCreatedEvent;
use App\Events\NewThreadCreatedEvent;
use App\Listeners\NotifyUserAboutNewComment;
use App\Listeners\UpvoteMyOwnThread;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        NewThreadCreatedEvent::class => [
            UpvoteMyOwnThread::class
        ],
        NewCommentCreatedEvent::class => [
            NotifyUserAboutNewComment::class,
            UpvoteMyOwnThread::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
