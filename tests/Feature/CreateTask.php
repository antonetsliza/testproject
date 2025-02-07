<?php

use App\Models\Task;

test('can access create page', function () {
    $response = $this->get(route('tasks.create'));

    $response->assertStatus(200);
});

it('can create a task', function () {
    $task = Task::factory()->create();

    putJson(
        route('tasks.store'),
        ['title' => 'test title'],
    )->assertSuccessful();

    expect(
        $task->refresh()
    )->title->toEqual('test title');
});
