@php
    use Carbon\Carbon;
@endphp

<x-app-layout>
    <div class="flex">
        <div class="m-auto">
            <div class="mt-2">
                <div class="m-3 mb-6 mr-36">
                    <x-link-button href="/tasks/create">New Task</x-link-button>
                </div>
            </div>
        </div>
    </div>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(!$tasks->count())
                        <div class="flex">
                            <div class="m-auto">
                                <div class="mt-2">
                                    <div class="flex lg:justify-center lg:col-start-2">
                                        No available tasks here
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">
                        @foreach ($tasks as $task)
                            <div class="p-6 flex space-x-2">
                                <div class="flex-1">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <span class="text-gray-800"><b>Created by: </b>{{ $task->owner->name }}</span>
                                            <small
                                                class="ml-2 text-sm text-gray-600">{{ $task->created_at->format('j M Y') }}</small>
                                            @unless ($task->created_at->eq($task->updated_at))
                                                <small class="text-sm text-gray-600">
                                                    &middot; {{ __('edited') }}</small>
                                            @endunless
                                        </div>
                                        <span class="text-gray-800"><b>Assigned to: </b>
                                            @if($task->target)
                                                {{ $task->target->name }}
                                            @else
                                                none
                                            @endif
                                        </span>

                                        @if ($task->owner_id == auth()->user()->getAuthIdentifier()
                                            || $task->target_id == auth()->user()->getAuthIdentifier())
                                            <x-link-button :href="route('tasks.edit', $task)">
                                                {{ __('Edit') }}
                                            </x-link-button>
                                            <x-link-button :href="route('tasks.assign-edit', $task)">
                                                {{ __('Assign') }}
                                            </x-link-button>

                                            @if($task->status != 2)
                                                <form method="POST" action="{{ route('tasks.complete', $task) }}">
                                                    @csrf
                                                    @method('patch')
                                                    <x-link-button :href="route('tasks.complete', $task)"
                                                                   onclick="event.preventDefault(); this.closest('form').submit();">
                                                        {{ __('Complete') }}
                                                    </x-link-button>
                                                </form>
                                            @endif

{{--                                            <form method="POST" action="{{ route('tasks.destroy', $task) }}">--}}
{{--                                                @csrf--}}
{{--                                                @method('delete')--}}
{{--                                                <x-link-button :href="route('tasks.destroy', $task)"--}}
{{--                                                                 onclick="event.preventDefault(); this.closest('form').submit();">--}}
{{--                                                    {{ __('Delete') }}--}}
{{--                                                </x-link-button>--}}
{{--                                            </form>--}}
                                        @endif
                                    </div>
                                    <p class="mt-4 text-lg text-gray-900">
                                        @php
                                            $task->due_date = Carbon::parse($task->due_date);
                                        @endphp
                                        <b>Due date:</b>
                                        <small class="ml-2 text-sm text-gray-600">{{ $task->due_date->format('j M Y') }}</small><br>
                                        <b>Title:</b>
                                        <span class="text-gray-800">{{ $task->title }}</span><br>
                                        <b>Description:</b><br>
                                        <span class="text-gray-800">{{ $task->description }}</span><br>
                                        <b>Status:</b>
                                        <span class="text-gray-800">{{ $task->statusAlias() }}</span><br>
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div>
                {{$tasks->links()}}
            </div>
        </div>
    </div>
</x-app-layout>
