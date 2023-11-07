<?php

namespace App\Http\Controllers;

use App\Http\Resources\KanbanResource;
use App\Producers\ExportKanbanProducer;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;

#[OpenApi\PathItem]
class KanbanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    #[OpenApi\Operation]
    public function index(): JsonResponse
    {
        $kanban = auth()->user()->kanban->load('sections.notes');

        return response()->json(new KanbanResource($kanban));
    }
    /**
     * Export kanban.
     */
    #[OpenApi\Operation]
    public function export(): \Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
//        ExportKanban::dispatch(auth()->user());
        app(ExportKanbanProducer::class)->send(auth()->user());
        return response(Response::HTTP_ACCEPTED);
    }
}
