<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Problem;
use App\Models\User;

class ProblemController extends Controller
{
    public function index(Request $request)
    {
        // dd($request->user()->problems()->get());
        
        return response()->json($request->user()->problems()->with('references','tasks')->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:150',
            'description' => 'nullable|string'
        ]);

        $problem = $request->user()->problems()->create($request->only('title','description'));
        return response()->json($problem, 201);
    }

    public function show(Request $request, $id)
    {
        $problem = $request->user()->problems()->findOrFail($id);
        return response()->json($problem);
    }

    public function update(Request $request, $id)
    {
        $problem = $request->user()->problems()->findOrFail($id);

        $request->validate([
            'title' => 'sometimes|required|string|max:150',
            'description' => 'nullable|string'
        ]);

        $problem->update($request->only('title','description'));
        return response()->json($problem);
    }

    public function destroy(Request $request, $id)
    {
        $problem = $request->user()->problems()->findOrFail($id);
        $problem->delete();
        return response()->json(['message' => 'Problem deleted']);
    }
}
