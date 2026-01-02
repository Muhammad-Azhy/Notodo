<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attachment;

class AttachmentController extends Controller
{
    public function index(Request $request)
    {
        return response()->json($request->user()->attachments()->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'file_path' => 'required|string',
            'file_type' => 'nullable|string',
            'reference_id' => 'nullable|exists:references,id',
            'task_id' => 'nullable|exists:tasks,id',
        ]);

        $attachment = $request->user()->attachments()->create($request->only('file_path','file_type','reference_id','task_id'));
        return response()->json($attachment, 201);
    }

    public function show(Request $request, $id)
    {
        $attachment = $request->user()->attachments()->findOrFail($id);
        return response()->json($attachment);
    }

    public function update(Request $request, $id)
    {
        $attachment = $request->user()->attachments()->findOrFail($id);

        $request->validate([
            'file_path' => 'sometimes|required|string',
            'file_type' => 'nullable|string',
            'reference_id' => 'nullable|exists:references,id',
            'task_id' => 'nullable|exists:tasks,id',
        ]);

        $attachment->update($request->only('file_path','file_type','reference_id','task_id'));
        return response()->json($attachment);
    }

    public function destroy(Request $request, $id)
    {
        $attachment = $request->user()->attachments()->findOrFail($id);
        $attachment->delete();
        return response()->json(['message' => 'Attachment deleted']);
    }
}
