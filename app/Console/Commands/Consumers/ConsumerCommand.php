<?php

namespace App\Console\Commands\Consumers;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use PhpAmqpLib\Channel\AbstractChannel;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

abstract class ConsumerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
//    protected $signature = 'rabbitmq:consumer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run rabbitmq consumer';
    protected AMQPStreamConnection $connection;
    protected AbstractChannel|AMQPChannel $channel;
    protected string $queue;
    protected int $allowCountRepeat = 2;

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->connection = new AMQPStreamConnection(
            config('rabbitmq.host'),
            config('rabbitmq.port'),
            config('rabbitmq.user'),
            config('rabbitmq.password')
        );
        $this->channel = $this->connection->channel();
        $this->channel->queue_declare($this->queue, durable: true, auto_delete: false);
        $this->channel->basic_qos(null, 1, null);
        $this->channel->basic_consume($this->queue, callback: [$this, 'basicCallback']);

        while ($this->channel->is_consuming()) {
            $this->channel->wait();
        }
    }

    public function basicCallback(AMQPMessage $message): void
    {
        $properties = $message->get_properties();
        $countRepeat = null;
        if (isset($properties['application_headers'])) {
            $headers = $message->get('application_headers')->getNativeData();
            $countRepeat = $headers['x-death'][0]['count'] ?? null;
        }

        if ($countRepeat && $countRepeat >= $this->allowCountRepeat) {
            Log::error('Error message not consuming. AMQPMessage ' . $message->getBody());
            $message->ack();
        } else {
            try {
                $result = $this->callback($message);
            } catch (\Throwable $throwable) {
                $result = false;
            }

            if ($result) {
                $message->ack();
            } else {
                $message->nack();
            }
        }
    }

    public function __destruct()
    {
        if (isset($this->connection)) {
            $this->connection->close();
            $this->channel->close();
        }
    }

    abstract protected function callback(AMQPMessage $message): bool;
}
