<?php

// RESPONSÁVEL POR ACOMPANHAR A PRODUÇÃO/FILA DE PEDIDOS E ATUALIZAÇÃO DE STATUS.

header('Content-Type: application/json; charset=utf-8');

require "./config.php";
require "./src/geral/Utils/RespostasJson.php";
require "./src/producao/Controllers/PedidoController.php";
require "./src/producao/External/MySqlConnection.php";

use Producao\External\MySqlConnection;
use Producao\Controllers\PedidoController;

$dbConnection = new MySqlConnection();
$pedidoController = new PedidoController();

if (!empty($_GET["acao"])) {
    switch ($_GET["acao"]) {

        case "obterPedidos":
            $pedidos = $pedidoController->obterPedidos($dbConnection);
            if (empty($pedidos)) {
                retornarRespostaJSON("Nenhum pedido encontrado.", 200);
                exit;
            }
            retornarRespostaJSON($pedidos, 200);
            break;

        case "atualizarStatusPedido":
            $id = !empty($_POST["id"]) ? (int)$_POST["id"] : 0;
            $status = $_POST["status"] ?? "";
            $atualizarStatusPedido = $pedidoController->atualizarStatusPedido($dbConnection, $id, $status);

            if (!$atualizarStatusPedido) {
                retornarRespostaJSON("Ocorreu um erro ao atualizar o status do pedido.", 500);
                exit;
            }
            retornarRespostaJSON("Status do pedido atualizado com sucesso.", 200);
            break;

        default:
            echo '{"mensagem": "A ação informada é inválida."}';
            http_response_code(400);
    }
}
