<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {

        return response()->json($request->user()->tasks()->get());
    }
    public function tasksByProblem($problemId)
{
    $tasks = Task::where('problem_id', $problemId)->get();
    return response()->json($tasks);
}


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'done' => 'nullable|boolean',
            'problem_id' => 'nullable|exists:problems,id',
        ]);
        $task = Task::create([
            'user_id' => $request->user()->id,
            'title' => $request->title,
            'done' => $request->done ?? false,
            'problem_id' => $request->problem_id??null,
        ]);

        return response()->json($task, 201);
    }

    public function show($id)
    {
        return Task::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        if ($request->has('title')) $task->title = $request->title;
        if ($request->has('done')) $task->done = $request->done;
        if ($request->has('problem_id')) $task->problem_id = $request->problem_id;

        $task->save();

        return response()->json($task);
    }

    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return response()->json(['message' => 'Task deleted']);
    }
}
