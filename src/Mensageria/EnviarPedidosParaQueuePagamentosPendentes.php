<?php

require '../../vendor/autoload.php';
require '../../config.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection(RABBITMQ_HOST, RABBITMQ_PORT, RABBITMQ_USERNAME, RABBITMQ_PASSWORD);
$channel = $connection->channel();

$channel->queue_declare('pedidos', false, true, false, false);

$callback = function ($msg) use ($channel) {
    $channel->queue_declare('pagamentos_pendentes', false, true, false, false);
    $msg = new AMQPMessage($msg->body);
    $channel->basic_publish($msg, '', 'pagamentos_pendentes');
};

$channel->basic_consume('pedidos', '', false, true, false, false, $callback);

try {
    $channel->consume();
} catch (\Throwable $exception) {
    echo $exception->getMessage();
}
