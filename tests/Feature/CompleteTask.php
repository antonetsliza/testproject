<?php

use App\Models\Task;

it('can complete task', function () {
    $task = Task::factory()->create();

    putJson(
        route('tasks.complete'),
        ['status' => 2],
    )->assertSuccessful();

    expect(
        $task->refresh()
    )->status->toEqual(2);
});
