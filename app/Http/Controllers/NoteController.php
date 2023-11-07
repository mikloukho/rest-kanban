<?php

namespace App\Http\Controllers;

use App\Http\Requests\NoteRequest;
use App\Http\Resources\NoteResource;
use App\Models\Note;
use App\Models\Section;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;

#[OpenApi\PathItem]
class NoteController extends Controller
{
    /**
     * Store a newly created note in storage.
     */
    #[OpenApi\Operation]
    public function store(NoteRequest $request, Section $section): JsonResponse
    {
        $this->authorize('isOwner', $section);

        $note = $section->notes()->create($request->validated());

        return response()->json(new NoteResource($note), Response::HTTP_CREATED);
    }

    /**
     * Display the specified note.
     */
    #[OpenApi\Operation]
    public function show(Note $note): JsonResponse
    {
        $this->authorize('isOwner', [$note]);
        $note->load('comments');
        return response()->json(new NoteResource($note));
    }

    /**
     * Update the specified note in storage.
     */
    #[OpenApi\Operation]
    public function update(NoteRequest $request, Note $note): JsonResponse
    {
        $this->authorize('isOwner', [$note]);
        $note->update($request->validated());

        return response()->json(new NoteResource($note));
    }

    /**
     * Remove the specified note from storage.
     */
    #[OpenApi\Operation]
    public function destroy(Note $note): Response
    {
        $this->authorize('isOwner', [$note]);
        $note->delete();

        return response()->noContent();
    }

    /**
     * Move the specified note to other section.
     */
    #[OpenApi\Operation]
    public function move(Section $section, Note $note): JsonResponse
    {
        $this->authorize('move', [$note, $section]);
        $note->section()->associate($section)->save();

        return response()->json(new NoteResource($note));
    }
}
