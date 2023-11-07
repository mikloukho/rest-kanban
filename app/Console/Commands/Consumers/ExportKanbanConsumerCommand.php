<?php

namespace App\Console\Commands\Consumers;

use App\Actions\ExportKanbanAction;
use App\Models\User;
use App\Producers\ExportKanbanProducer;
use PhpAmqpLib\Message\AMQPMessage;

class ExportKanbanConsumerCommand extends ConsumerCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rabbitmq:consumer:export-kanban';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export kanban consume';

    public function __construct()
    {
        parent::__construct();
        $this->queue = ExportKanbanProducer::QUEUE;
    }

    protected function callback(AMQPMessage $message): bool
    {
        $data = json_decode($message->getBody(), true, 512, JSON_THROW_ON_ERROR);
        if (!$user = User::find($data['id'])) {
            return false;
        }
        app(ExportKanbanAction::class)($user);
        return true;
    }
}
