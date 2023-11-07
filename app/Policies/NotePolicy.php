<?php

namespace App\Policies;

use App\Models\Note;
use App\Models\Section;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class NotePolicy
{
    public function __construct(protected SectionPolicy $sectionPolicy)
    {
    }

    public function move(User $user, Note $note, Section $section): bool
    {
        return $this->sectionPolicy->isOwner($user, $section) &&
            $this->isOwner($user, $note);
    }

    public function isOwner(User $user, Note $note): bool
    {
        return (bool)$user->kanban->notes()->find($note->id);
    }
}
