<?php

use App\Models\Task;
use App\Models\User;

test('can access assign user page', function () {
    $response = $this->get(route('tasks.assign-edit'));

    $response->assertStatus(200);
});

it('can update a task', function () {
    $user = User::factory()->create();
    $task = Task::factory()->create();

    putJson(
        route('tasks.assign-update'),
        ['target_id' => $user->id],
    )->assertSuccessful();

    expect(
        $task->refresh()
    )->target_id->toEqual($user->id);
});
