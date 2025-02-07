<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <form method="POST" action="{{ route('tasks.store') }}">
            @csrf

            <b>New task</b>

            <input id="title" name="title" placeholder="Task title..."
                   value="{{old('title')}}"
                   class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 mb-4"
            >
            <x-input-error :messages="$errors->get('title')" class="mt-2 mb-6" />

            <textarea id="description" name="description" rows="4"
                      class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 mb-4"
                      placeholder="Task description...">{{ old('description') }}</textarea>
            <x-input-error :messages="$errors->get('description')" class="mt-2 mb-6" />

            <input name="due_date" id="due_date" type="date" placeholder="Due date"
                   value="{{old('due_date')}}"
                   class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 mb-4"
            />
            <x-input-error :messages="$errors->get('due_date')" class="mt-2 mb-6" />

            <x-primary-button class="mt-4 bg-indigo-600">{{ __('Save') }}</x-primary-button>
        </form>
    </div>
</x-app-layout>
