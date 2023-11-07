<?php

namespace App\Http\Controllers;

use App\Http\Requests\SectionRequest;
use App\Http\Resources\SectionResource;
use App\Models\Section;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;
#[OpenApi\PathItem]
class SectionController extends Controller
{
    /**
     * Store a newly created section in storage.
     */
    #[OpenApi\Operation]
    public function store(SectionRequest $request): JsonResponse
    {
        $section = auth()->user()->kanban->sections()->create($request->validated());

        return response()->json(new SectionResource($section), Response::HTTP_CREATED);
    }

    /**
     * Display the specified section.
     * @param Section $section Section ID
     */
    #[OpenApi\Operation]
    public function show(Section $section): JsonResponse
    {
        $this->authorize('isOwner', $section);

        return response()->json(new SectionResource($section));
    }

    /**
     * Update the specified section in storage.
     * @param Section $section Section ID
     */
    #[OpenApi\Operation]
    public function update(SectionRequest $request, Section $section): JsonResponse
    {
        $this->authorize('isOwner', $section);
        $section->update($request->validated());

        return response()->json(new SectionResource($section));
    }

    /**
     * Remove the specified resource from storage.
     * @param Section $section Section ID
     */
    #[OpenApi\Operation]
    public function destroy(Section $section): \Illuminate\Http\Response
    {
        $this->authorize('delete', $section);
        $section->delete();

        return response()->noContent();
    }
}
