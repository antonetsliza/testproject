<?php

namespace App\Http\Middleware;

use App\Models\Task;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

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

//        dump($request->user()->id);
//        dump($task->owner_id);
//        dd($task->target_id);

        if($request->user()->id != $task->owner_id
            && $request->user()->id != $task->target_id) {
            return redirect(route('tasks.index'));
        }

        return $next($request);
    }
}
