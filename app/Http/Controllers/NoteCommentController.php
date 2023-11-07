<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Note;
use Symfony\Component\HttpFoundation\Response;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;

/**
 * Create note comment.
 */
#[OpenApi\PathItem]
class NoteCommentController extends Controller
{
    public function __invoke(CommentRequest $request, Note $note): \Illuminate\Http\JsonResponse
    {
        $this->authorize('isOwner', $note);
        $comment = $note->comments()->create($request->validated() + ['user_id' => auth()->id()]);
        return response()->json(new CommentResource($comment), Response::HTTP_CREATED);
    }
}
