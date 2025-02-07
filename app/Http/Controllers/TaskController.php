<?php

namespace App\Http\Controllers;

use App\Enums\TaskStatus;
use App\Listeners\TaskAssigned;
use App\Listeners\TaskCompleted;
use App\Models\Task;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::with('owner')->with('target')->latest()->paginate(5);

        return view('tasks.list', [
            'tasks' => $tasks
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::query()->select('id', 'name')
            ->whereNot('id', Auth::user()->getAuthIdentifier())->get();

        return view('tasks.create', [
            'users' => $users
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        $validated = $request->validated();
        $validated['owner_id'] = Auth::user()->getAuthIdentifier();
        $validated['target_id'] = null;
        $validated['status'] = TaskStatus::PENDING;

        Task::create($validated);

        return redirect(route('tasks.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        return view('tasks.edit', [
            'task' => $task,
        ]);
    }

    public function assignUserForm(Task $task)
    {
        $users = User::query()->select('id', 'name')->get();

        return view('tasks.assign', [
            'task' => $task,
            'users' => $users,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $validated = $request->validated();

        $task->update($validated);

        return redirect(route('tasks.index'));
    }

    public function assignUser(Request $request, Task $task)
    {
        $validated = $request->validate([
            'target_id' => 'numeric',
        ]);

        if(!$validated['target_id'])
            $validated['target_id'] = null;

        $validated['status'] = !$validated['target_id'] ? TaskStatus::PENDING : TaskStatus::IN_PROGRESS;

        $task->update($validated);

        if($validated['target_id']) {
            dispatch(new TaskAssigned($task));
        }

        return redirect(route('tasks.index'));
    }

    public function completeTask(Request $request)
    {
        $task_id =  preg_replace('/[^0-9]/', '', $request->route('task'));

        $task = Task::findOrFail($task_id);

        $task->update(['status' => TaskStatus::COMPLETED]);

        dispatch(new TaskCompleted($task));

        return redirect(route('tasks.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        Gate::authorize('delete', $task);

        $task->delete();

        return redirect(route('tasks.index'));
    }
}
