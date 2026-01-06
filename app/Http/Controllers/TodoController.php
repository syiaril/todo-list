<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function index()
    {
        $todos = Todo::latest()->get();
        return view('todos.index', compact('todos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
        ]);

        Todo::create([
            'title' => $request->title,
            'is_completed' => false,
        ]);

        return redirect()->route('todos.index');
    }

    public function update(Request $request, Todo $todo)
    {
        // Toggle completion status if only that is sent, otherwise simple update
        if ($request->has('is_completed')) {
            $todo->update(['is_completed' => $request->boolean('is_completed')]);
        } else {
             $request->validate([
                'title' => 'required|max:255',
            ]);
            $todo->update($request->only('title'));
        }

        return redirect()->route('todos.index');
    }

    public function destroy(Todo $todo)
    {
        $todo->delete();
        return redirect()->route('todos.index');
    }
}
