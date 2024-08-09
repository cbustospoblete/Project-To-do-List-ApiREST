<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        return Task::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|string',
            'due_date' => 'nullable|date_format:Y-m-d H:i:s',
        ]);

        return Task::create($request->all());
    }

    public function show(Task $task)
    {
        return $task;
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|string',
            'due_date' => 'nullable|date_format:Y-m-d H:i:s',
        ]);

        $task->update($request->all());

        return $task;
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return response()->json(['message' => 'Task deleted successfully']);
    }
}
