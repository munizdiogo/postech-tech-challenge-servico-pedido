<?php

// RESPONSÁVEL POR RETORNAR AS INFORMAÇÕES NECESSÁRIAS PARA MONTAR UM PEDIDO.

header('Content-Type: application/json; charset=utf-8');
require "config.php";
require "./utils/RespostasJson.php";
require "./src/External/MySqlConnection.php";
require "./src/Controllers/PedidoController.php";

use Pedido\External\MySqlConnection;
use Pedido\Controllers\PedidoController;

$dbConnection = new MySqlConnection();
$pedidoController = new PedidoController();

if (!empty($_GET["acao"]) && $_GET["acao"] == "cadastrar") {
    $jsonDados = file_get_contents("php://input");
    $dados = json_decode($jsonDados, true) ?? [];

    $idPedido = $pedidoController->cadastrar($dbConnection, $dados);

    if (empty($idPedido)) {
        retornarRespostaJSON("Ocorreu um erro ao salvar os dados do pedido.", 500);
        exit;
    }
    retornarRespostaJSON(["id" => $idPedido, "mensagem" => "Pedido criado com sucesso."], 201);
} else {
    echo '{"mensagem": "A ação informada é inválida."}';
    http_response_code(400);
}
