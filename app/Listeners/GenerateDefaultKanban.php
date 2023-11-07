<?php

namespace App\Listeners;

use App\Actions\GenerateDefaultKanbanAction;
use App\Models\Comment;
use App\Models\Kanban;
use App\Models\Note;
use App\Models\Section;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;

class GenerateDefaultKanban
//    implements ShouldQueue
{
    /**
     * Handle the event.
     * @throws \Exception
     */
    public function handle(Registered $event): void
    {
        app(GenerateDefaultKanbanAction::class)($event->user);
    }
}
