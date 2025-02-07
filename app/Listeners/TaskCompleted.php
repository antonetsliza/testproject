<?php

namespace App\Listeners;

use App\Events\TaskCompleted as TaskCompletedEvent;
use App\Models\User;
use App\Notifications\TaskCompleted as TaskCompletedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;

class TaskCompleted implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(TaskCompletedEvent $event): void
    {
        $users = User::find([$event->task->target_id, $event->task->owner_id]);

        foreach ($users as $user) {
            $user->notify(new TaskCompletedNotification($event->task));
        }
    }
}
