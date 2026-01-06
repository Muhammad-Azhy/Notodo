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
        // Get all references for the logged-in user with attachments
        $references = $request->user()
                              ->references()
                              ->with('attachments')
                              ->get()
                              ->map(function ($ref) {
                                  return [
                                      'id' => $ref->id,
                                      'title' => $ref->title,
                                      'type' => $ref->type,
                                      'content' => $ref->content,
                                      'problem_id' => $ref->problem_id,
                                      'attachments' => $ref->attachments->map(function ($att) {
                                          return [
                                              'id' => $att->id,
                                              'filename' => $att->filename,
                                              'path' => $att->path,
                                          ];
                                      }),
                                  ];
                              });

        return response()->json($references);
    }

    // GET /api/references/{id}
    public function show($id)
    {
        $reference = Reference::with('attachments')->findOrFail($id);
        $this->authorize('view', $reference);

        // Format JSON consistently
        $data = [
            'id' => $reference->id,
            'title' => $reference->title,
            'type' => $reference->type,
            'content' => $reference->content,
            'problem_id' => $reference->problem_id,
            'attachments' => $reference->attachments->map(function ($att) {
                return [
                    'id' => $att->id,
                    'filename' => $att->filename,
                    'path' => $att->path,
                ];
            }),
        ];

        return response()->json($data);
    }

    // POST /api/references
    public function store(Request $request)
    {
        $this->authorize('create', Reference::class);

        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:text,image',
            'content' => 'nullable|string',
        ]);

        $reference = Reference::create([
            'title' => $request->title,
            'type' => $request->type,
            'content' => $request->content ?? null,
            'problem_id' => $request->problem_id ?? null,
            'user_id' => $request->user()->id,
        ]);

        // If type is image and attachments are provided
        if ($request->has('attachments') && is_array($request->attachments)) {
            foreach ($request->attachments as $att) {
                $reference->attachments()->create([
                    'filename' => $att['filename'],
                    'path' => $att['path'],
                ]);
            }
        }

        // Return reference with attachments
        $reference->load('attachments');

        $data = [
            'id' => $reference->id,
            'title' => $reference->title,
            'type' => $reference->type,
            'content' => $reference->content,
            'problem_id' => $reference->problem_id,
            'attachments' => $reference->attachments->map(function ($att) {
                return [
                    'id' => $att->id,
                    'filename' => $att->filename,
                    'path' => $att->path,
                ];
            }),
        ];

        return response()->json($data, 201);
    }

    // PUT /api/references/{id}
    public function update(Request $request, $id)
    {
        // response()->json(['message' => 'Update reference called ','id'=>$id]);
        $reference = $request->user()->references()
                              ->with('attachments')
                              ->findOrFail($id);
        $this->authorize('update', $reference);

        $reference->update($request->only(['title', 'type', 'content', 'problem_id']));

        // Optionally handle attachments update here

        $reference->load('attachments');

        $data = [
            'id' => $reference->id,
            'title' => $reference->title,
            'type' => $reference->type,
            'content' => $reference->content,
            'problem_id' => $reference->problem_id,
            'attachments' => $reference->attachments->map(function ($att) {
                return [
                    'id' => $att->id,
                    'filename' => $att->filename,
                    'path' => $att->path,
                ];
            }),
        ];

        return response()->json($data);
    }

    // DELETE /api/references/{id}
    public function destroy($id)
    {
        $reference = Reference::findOrFail($id);
        $this->authorize('delete', $reference);
        $reference->delete();

        return response()->json(['message' => 'Reference deleted']);
    }
    public function referencesByProblem($problemId)
{
    $refs = Reference::where('problem_id', $problemId)->get();
    return response()->json($refs);
}

}
