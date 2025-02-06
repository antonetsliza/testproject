<?php

namespace App\Http\Controllers;

use App\Enums\TaskStatus;
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
        $tasks = Task::with('owner')->with('target')->orderBy('due_date')->get();

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
        if(!$validated['target_id'])
            $validated['target_id'] = null;

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
        //Gate::authorize('update', $task);

        $users = User::query()->select('id', 'name')
            ->whereNot('id', Auth::user()->getAuthIdentifier())->get();

        $statuses = [
            TaskStatus::PENDING => 'pending',
            TaskStatus::IN_PROGRESS => 'in progress',
            TaskStatus::COMPLETED => 'completed'
        ];

        return view('tasks.edit', [
            'task' => $task,
            'users' => $users,
            'statuses' => $statuses
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        //Gate::authorize('update', $task);

        $validated = $request->validated();
        if(!$validated['target_id'])
            $validated['target_id'] = null;

        //dd($validated);

        $task->update($validated);

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
