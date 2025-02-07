<?php

use App\Models\Task;

test('can access edit page', function () {
    $response = $this->get(route('tasks.edit'));

    $response->assertStatus(200);
});

it('can update a task', function () {
    $task = Task::factory()->create();

    putJson(
        route('tasks.update'),
        ['title' => 'test title updated'],
    )->assertSuccessful();

    expect(
        $task->refresh()
    )->title->toEqual('test title updated');
});
