<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reference;
use App\Models\Attachment;

class ReferenceController extends Controller
{
    // GET /api/references
    public function index(Request $request)
    {
        $references = $request->user()->references()->with('attachments')->get();
        return response()->json($references);
    }

    public function show($id)
{
    $reference = Reference::findOrFail($id);
    $this->authorize('view', $reference); // policy check
    return response()->json($reference); 
}

public function update(Request $request, $id)
{
    $reference = Reference::findOrFail($id);
    $this->authorize('update', $reference); // only owner
    $reference->update($request->only(['title', 'type', 'content', 'problem_id']));
    return response()->json($reference);
}

public function destroy($id)
{
    $reference = Reference::findOrFail($id);
    $this->authorize('delete', $reference);
    $reference->delete();
    return response()->json(['message' => 'Reference deleted']);
}

public function store(Request $request)
{
    $this->authorize('create', Reference::class); // logged in users
    $request->validate([
        'title' => 'required|string|max:255',
        'type' => 'required|in:text,image',
    ]);

    $reference = Reference::create([
        'title' => $request->title,
        'type' => $request->type,
        'content' => $request->content ?? null,
        'problem_id' => $request->problem_id ?? null,
        'user_id' => $request->user()->id, // set owner
    ]);

    return response()->json($reference, 201);
}
}
