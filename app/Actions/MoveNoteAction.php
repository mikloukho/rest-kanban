<?php

namespace App\Actions;

use App\Models\Note;
use App\Models\Section;

class MoveNoteAction
{
    public function __invoke(Note $note, Section $oldSection, Section $newSection)
    {
        // TODO: Implement __invoke() method.
    }
}
