<?php

namespace Tests\Feature;

use App\Actions\GenerateDefaultKanbanAction;
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


class NoteTest extends TestCase
{
    use RefreshDatabase, RegisterUserTrait;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->registerUser();
    }

    public function test_can_create_note(): void
    {
        $section = auth()->user()->kanban->sections()->first();
        $route = route('notes.store', [$section]);
        $response = $this->post($route, Note::factory()->definition());

        $response
            ->assertStatus(Response::HTTP_CREATED);
    }

    public function test_can_update_note(): void
    {
        $note = auth()->user()->kanban->notes()->first();
        $route = route('notes.update', [$note]);
        $response = $this->put($route, Note::factory()->definition());

        $response
            ->assertStatus(Response::HTTP_OK);
    }

    public function test_can_delete_note(): void
    {
        $note = auth()->user()->kanban->notes()->first();
        $route = route('notes.destroy', [$note]);
        $response = $this->delete($route);
        $this->assertNull(Note::find($note->id));
        $response
            ->assertStatus(Response::HTTP_NO_CONTENT);
    }

    public function test_can_move_note(): void
    {
        $sections = auth()->user()->kanban->sections()->take(2)->with('notes')->get();
        $oldSection = $sections->first();
        $newSection = $sections->last();
        $note = $oldSection->first()->notes->first();

        $uri = route('notes.move', [$newSection, $note]);
        $response = $this->put($uri);
        $this->assertTrue($newSection->notes()->find($note)->count() === 1);
        $response
            ->assertStatus(Response::HTTP_OK);
    }


}
