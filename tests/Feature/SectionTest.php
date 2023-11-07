<?php

namespace Tests\Feature;

use App\Actions\GenerateDefaultKanbanAction;
use App\Models\Section;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;


class SectionTest extends TestCase
{
    use RefreshDatabase, RegisterUserTrait;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->registerUser();
    }

    public function test_can_create_section(): void
    {
        $response = $this->post(route('sections.store'), Section::factory()->definition());

        $response
            ->assertStatus(Response::HTTP_CREATED);
    }

    public function test_can_update_section(): void
    {
        $section = auth()->user()->kanban->sections()->first();
        $response = $this->put(route('sections.update', $section), Section::factory()->definition());

        $response
            ->assertStatus(Response::HTTP_OK);
    }

    public function test_cant_delete_section(): void
    {
        $section = auth()->user()->kanban->sections()->has('notes')->first();
        $response = $this->delete(route('sections.destroy', $section));

        $response
            ->assertStatus(Response::HTTP_CONFLICT);
    }

    public function test_cant_update_section(): void
    {
        $this->registerUser();
        $unAuthUser = User::where('id', '!=', auth()->id())->first();
        $section = $unAuthUser->kanban->sections()->first();

        $response = $this->put(route('sections.update', $section), Section::factory()->definition());

        $response
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }



}
