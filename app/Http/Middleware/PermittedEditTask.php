<?php

namespace App\Http\Middleware;

use App\Models\Task;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use function PHPUnit\Framework\isInt;

class PermittedEditTask
{
    public function __construct()
    {

    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $task = $request->route('task');

        if(!isset($task->id)) {
            $task = Task::findOrFail($task);
        }

        if($request->user()->id != $task->owner_id
            && $request->user()->id != $task->target_id) {
            return redirect(route('tasks.index'));
        }

        return $next($request);
    }
}
