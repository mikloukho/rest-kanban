<?php

namespace App\Producers;

use PhpAmqpLib\Channel\AbstractChannel;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;

abstract class Producer
{
    const QUEUE = 'default';
    protected AMQPStreamConnection $connection;
    protected AbstractChannel|AMQPChannel $channel;

    public function settingRabbit(): void
    {
        if (!isset($this->connection)) {
            $this->connection = new AMQPStreamConnection(
                config('rabbitmq.host'),
                config('rabbitmq.port'),
                config('rabbitmq.user'),
                config('rabbitmq.password')
            );
            $this->channel = $this->connection->channel();
            $this->channel->queue_declare(
                static::QUEUE,
                durable: true,
                auto_delete: false
            );
        }
    }

    public function __destruct()
    {
        if (isset($this->connection)) {
            $this->channel->close();
            $this->connection->close();
        }
    }
}
