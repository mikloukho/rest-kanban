<?php
namespace Tests\Feature;
use App\Actions\GenerateDefaultKanbanAction;
use App\Models\User;

trait RegisterUserTrait
{
    protected function registerUser(): void
    {
        $this->user = User::factory()->create();
        app(GenerateDefaultKanbanAction::class)($this->user);
        auth()->login($this->user);
    }
}
