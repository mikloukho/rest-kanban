<?php

namespace Tests\Feature;

use App\Actions\GenerateDefaultKanbanAction;
use App\Models\Comment;
use App\Models\Note;
use App\Models\User;
use Database\Factories\NoteFactory;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;


class CommentTest extends TestCase
{
    use RefreshDatabase, RegisterUserTrait;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->registerUser();
    }

    public function test_can_create_comment_note(): void
    {
        $note = auth()->user()->kanban->notes()->first();
        $route = route('notes.comments.store', [$note]);

        $response = $this->post($route, Comment::factory()->definition());

        $response
            ->assertStatus(Response::HTTP_CREATED);
    }

    public function test_can_update_comment(): void
    {
        $comment = auth()->user()->comments()->first();
        $route = route('comments.update', [$comment]);
        $response = $this->put($route, Comment::factory()->definition());

        $response
            ->assertStatus(Response::HTTP_OK);
    }

    public function test_can_delete_comment(): void
    {
        $comment = auth()->user()->comments()->first();
        $route = route('comments.destroy', [$comment]);
        $response = $this->delete($route);
        $this->assertNull(Comment::find($comment->id));
        $response
            ->assertStatus(Response::HTTP_NO_CONTENT);
    }

}
