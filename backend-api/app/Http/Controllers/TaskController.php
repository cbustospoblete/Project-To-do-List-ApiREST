<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $tasks = Task::all();
            return response()->json($tasks);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve tasks.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(StoreTaskRequest $request): JsonResponse
    {
        try {
            $task = Task::create($request->validated());
            return response()->json($task, Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create task.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(Task $task): JsonResponse
    {
        try {
            return response()->json($task);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Task not found.'], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve task.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(UpdateTaskRequest $request, Task $task): JsonResponse
    {
        try {
            $task->update($request->validated());
            return response()->json($task);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update task.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(Task $task): JsonResponse
    {
        try {
            $task->delete();
            return response()->json(['message' => 'Task deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete task.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
