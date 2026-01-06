@extends('layouts.app')

@section('content')
<div class="mb-5">
    <h1 class="text-3xl font-bold text-gray-800 text-center">My Todo List</h1>
    <p class="text-gray-500 text-center mt-2">Manage your tasks efficiently</p>
</div>

<div class="mb-6">
    <form action="{{ route('todos.store') }}" method="POST" class="flex gap-2">
        @csrf
        <input type="text" name="title" placeholder="What needs to be done?" 
               class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition duration-150"
               required>
        <button type="submit" 
                class="px-6 py-3 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition duration-150 shadow-md">
            Add
        </button>
    </form>
    @error('title')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>

<div class="space-y-3">
    @forelse ($todos as $todo)
        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border border-gray-100 hover:shadow-sm transition duration-150 group">
            <div class="flex items-center gap-3 flex-1">
                <form action="{{ route('todos.update', $todo) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="is_completed" value="{{ $todo->is_completed ? '0' : '1' }}">
                    <button type="submit" class="text-2xl focus:outline-none {{ $todo->is_completed ? 'text-green-500' : 'text-gray-300 hover:text-green-500' }}">
                        @if($todo->is_completed)
                            <svg class="w-6 h-6 fill-current" viewBox="0 0 20 20"><path d="M0 11l2-2 5 5L18 3l2 2L7 18z"/></svg>
                        @else
                            <svg class="w-6 h-6 fill-current" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32z"/></svg>
                        @endif
                    </button>
                </form>
                
                <span class="text-lg {{ $todo->is_completed ? 'line-through text-gray-400' : 'text-gray-700' }}">
                    {{ $todo->title }}
                </span>
            </div>

            <form action="{{ route('todos.destroy', $todo) }}" method="POST" class="opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-400 hover:text-red-600 p-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </button>
            </form>
        </div>
    @empty
        <div class="text-center py-10">
            <p class="text-gray-400">No tasks yet. Add one above!</p>
        </div>
    @endforelse
</div>
@endsection
