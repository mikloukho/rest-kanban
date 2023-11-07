<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;

class CommentPolicy
{
    public function isOwner(User $user, Comment $comment): bool
    {
        return (bool)$user->comments()->find($comment->id);
    }
}
