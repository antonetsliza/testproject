<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <form method="POST" action="{{ route('tasks.assign-update', $task) }}">
            @csrf
            @method('patch')

            <b>Assign user</b>

            <select id="target_id" name="target_id"
                    class="block mt-3 p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 mb-4">
                <option value="0">Assign to...</option>
                @foreach($users as $user)
                    <option value="{{$user->id}}"
                            @if($user->id == $task->target_id) selected @endif>{{$user->name}}</option>
                @endforeach
            </select>

            <x-primary-button class="mt-4 bg-indigo-600">{{ __('Assign') }}</x-primary-button>
        </form>
    </div>
</x-app-layout>
