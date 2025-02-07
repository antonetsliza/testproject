<?php

namespace App\Listeners;

use App\Events\TaskAssigned as TaskAssignedEvent;
use App\Models\User;
use App\Notifications\TaskAssigned as TaskAssignedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;

class TaskAssigned implements ShouldQueue
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
    public function handle(TaskAssignedEvent $event): void
    {
        $user = User::find($event->task->target_id);

        $user->notify(new TaskAssignedNotification($event->task));
    }
}
