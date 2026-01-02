<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        return response()->json($request->user()->tasks()->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:150',
            'description' => 'nullable|string',
            'problem_id' => 'nullable|exists:problems,id',
            'is_completed' => 'nullable|boolean'
        ]);

        $task = $request->user()->tasks()->create($request->only('title','description','problem_id','is_completed'));
        return response()->json($task, 201);
    }

    public function show(Request $request, $id)
    {
        $task = $request->user()->tasks()->findOrFail($id);
        return response()->json($task);
    }

    public function update(Request $request, $id)
    {
        $task = $request->user()->tasks()->findOrFail($id);

        $request->validate([
            'title' => 'sometimes|required|string|max:150',
            'description' => 'nullable|string',
            'problem_id' => 'nullable|exists:problems,id',
            'is_completed' => 'nullable|boolean'
        ]);

        $task->update($request->only('title','description','problem_id','is_completed'));
        return response()->json($task);
    }

    public function destroy(Request $request, $id)
    {
        $task = $request->user()->tasks()->findOrFail($id);
        $task->delete();
        return response()->json(['message' => 'Task deleted']);
    }
}
