<?php

namespace App\Producers;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use PhpAmqpLib\Message\AMQPMessage;

class ExportKanbanProducer extends Producer
{
    public const QUEUE = 'export-kanban-queue';

    public function send(User $user): void
    {
        $this->settingRabbit();
        try {
            $msg = new AMQPMessage(
                $user->toJson()
            );
            $this->channel->basic_publish($msg, routing_key: $this::QUEUE);
        } catch (\Exception $e) {
            Log::error('Error export kanban . AMQPMessage' . $e->getMessage());
        }
    }
}
