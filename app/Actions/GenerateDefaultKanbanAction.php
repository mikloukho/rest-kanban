<?php

namespace App\Actions;

use App\Models\Comment;
use App\Models\Kanban;
use App\Models\Note;
use App\Models\Section;
use App\Models\User;

class GenerateDefaultKanbanAction
{
    public function __invoke(User $user): void
    {
        Kanban::factory()
            ->has(Section::factory(3)
                ->has(Note::factory(4)
                    ->has(Comment::factory(2, ['user_id' => $user])
                    )
                )
            )->create(['user_id' => $user]);
    }
}
