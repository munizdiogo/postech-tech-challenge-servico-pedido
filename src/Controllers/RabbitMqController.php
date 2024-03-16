<?php

require "vendor/autoload.php";

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMqController
{
    public function enviarMsgParaQueue($queue, $mensagem)
    {
        $connection = new AMQPStreamConnection (RABBITMQ_HOST, RABBITMQ_PORT, RABBITMQ_USERNAME, RABBITMQ_PASSWORD);
        $channel = $connection->channel();
        $channel->queue_declare($queue, false, true, false, false);

        $msg = new AMQPMessage($mensagem);
        $channel->basic_publish($msg, '', $queue);

        $channel->close();
        $connection->close();
    }
}
