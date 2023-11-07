<?php

namespace App\Actions;

use App\Mail\ExportKanban;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class ExportKanbanAction
{
    public function __invoke(User $user): void
    {
        $user->kanban->load('sections.notes.comments');
        Mail::to($user)->send(new ExportKanban($user->kanban));
    }

}
