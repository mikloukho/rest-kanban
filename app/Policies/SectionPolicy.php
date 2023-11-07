<?php

namespace App\Policies;

use App\Models\Section;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Http\Exceptions\HttpResponseException;
use \Symfony\Component\HttpFoundation\Response as ResponseCodes;

class SectionPolicy
{
    use HandlesAuthorization;

    public function delete(User $user, Section $section): bool|Response
    {
        if ($section->notes()->first()) {
            return $this->denyWithStatus(ResponseCodes::HTTP_CONFLICT,
                __("Can't delete a section while it has notes."));
        }
        return $this->isOwner($user, $section);
    }

    public function isOwner(User $user, Section $section): bool
    {
        return (bool)$user->kanban->sections()->find($section->id);
    }
}
