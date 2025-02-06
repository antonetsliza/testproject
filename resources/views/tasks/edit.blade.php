@php
    use Carbon\Carbon;
@endphp

<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <form method="POST" action="{{ route('tasks.update', $task) }}">
            @csrf
            @method('patch')

            <b>Edit task</b>

            <input id="title" name="title" placeholder="Task title..."
                   value="{{ old('title', $task->title) }}"
                   class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 mb-4"
            >
            <x-input-error :messages="$errors->get('title')" class="mt-2 mb-6" />

            <textarea id="description" name="description" rows="4"
                      class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 mb-4"
                      placeholder="Task description...">{{ old('description', $task->description) }}</textarea>
            <x-input-error :messages="$errors->get('description')" class="mt-2 mb-6" />

            @php
                $task->due_date = Carbon::parse($task->due_date);
            @endphp
            <input name="due_date" id="due_date" type="date" placeholder="Due date"
                   value="{{old('due_date', $task->due_date->format('Y-m-d'))}}"
                   class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 mb-4"
            />
            <x-input-error :messages="$errors->get('due_date')" class="mt-2 mb-6" />

            <select id="target_id" name="target_id"
                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 mb-4">
                <option value="0">Assign to...</option>
                @foreach($users as $user)
                    <option value="{{$user->id}}" @if($user->id == $task->target_id) selected @endif>{{$user->name}}</option>
                @endforeach
            </select>

            <select id="status" name="status"
                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 mb-4">
                @foreach($statuses as $key => $status)
                    <option value="{{$key}}" @if($key == $task->status) selected @endif>{{$status}}</option>
                @endforeach
            </select>

            <x-primary-button class="mt-4 bg-indigo-600">{{ __('Edit') }}</x-primary-button>
        </form>
    </div>
</x-app-layout>
