<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use Illuminate\Http\JsonResponse;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;

#[OpenApi\PathItem]
class CommentController extends Controller
{
    /**
     * Display the specified comment.
     * @param Comment $comment Comment ID
     */
    #[OpenApi\Operation]
    public function show(Comment $comment): JsonResponse
    {
        $this->authorize('isOwner', [$comment]);

        return response()->json(new CommentResource($comment));
    }

    /**
     * Update the specified comment in storage.
     * @param Comment $comment Comment ID
     */
    #[OpenApi\Operation]
    public function update(CommentRequest $request, Comment $comment): JsonResponse
    {
        $this->authorize('isOwner', [$comment]);
        $comment->update($request->validated());

        return response()->json(new CommentResource($comment));
    }

    /**
     * Remove the specified comment from storage.
     * @param Comment $comment Comment ID
     */
    #[OpenApi\Operation]
    public function destroy(Comment $comment): \Illuminate\Http\Response
    {
        $this->authorize('isOwner', [$comment]);
        $comment->delete();

        return response()->noContent();
    }
}
