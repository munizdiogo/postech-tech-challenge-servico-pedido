<?php

//  RESPONSÁVEL POR REALIZAR A COBRANÇA DE UM PEDIDO GERADO ANTERIORMENTE.

header('Content-Type: application/json; charset=utf-8');
require "./src/geral/Utils/RespostasJson.php";
require "./src/pagamento/External/MySqlConnection.php";
require "./src/pagamento/External/DynamoDBConnection.php";
require "./src/pagamento/Controllers/PagamentoController.php";
require "./src/pagamento/Controllers/PedidoController.php";

use Pagamento\External\MySqlConnection;
use Pagamento\External\DynamoDBConnection;
use Pagamento\Controllers\PagamentoController;
use Pagamento\Controllers\PedidoController;

$dbConnection = new MySqlConnection();
$dbConnectionNoSQL = new DynamoDBConnection();
$pedidoController = new PedidoController();
$pagamentoController = new PagamentoController();

if (!empty($_GET["acao"])) {
    switch ($_GET["acao"]) {

        case "atualizarStatus":
            $id = !empty($_POST["id"]) ? (int)$_POST["id"] : 0;
            $status = $_POST["status"] ?? "";
            $cpf = $_POST["cpf"] ?? "";
            $valor = $_POST["valor"] ?? "";
            $formaPagamento = $_POST["forma_pagamento"] ?? "";
            $dataCriacao = new DateTime('now');

            $dadosPagamento = [
                "IdTransacao" => random_string(10),
                "DataCriacao" => $dataCriacao->format('Y-m-d H:i:s'),
                "IdPedido" => $id,
                "Cpf" => $cpf,
                "Valor" => $valor,
                "FormaPagamento" => $formaPagamento,
                "Status" => $status
            ];

            foreach ($dadosPagamento as $chave => $valor) {
                if (empty($valor)) {
                    retornarRespostaJSON("O parametro $chave é obrigatório.", 400);
                    exit;
                }
            }

            $cadastrarPagamento = $pagamentoController->cadastrar($dbConnectionNoSQL, $dadosPagamento);

            if (!$cadastrarPagamento) {
                retornarRespostaJSON("Ocorreu um erro ao salvar os dados do pagamento.", 500);
                exit;
            }

            $atualizarStatusPagamentoPedido = $pedidoController->atualizarStatusPagamentoPedido($dbConnection, $id, $status);

            if (!$atualizarStatusPagamentoPedido) {
                retornarRespostaJSON("Ocorreu um erro ao atualizar o status do pagamento do pedido.", 500);
                exit;
            }
            retornarRespostaJSON("Status do pagamento do pedido atualizado com sucesso.", 200);
            break;

        case "obterStatusPorIdPedido":
            $id = !empty($_GET["id"]) ? (int)$_GET["id"] : 0;

            if (empty($id)) {
                retornarRespostaJSON("É obrigatório informar o ID do pedido.", 400);
                exit;
            }

            $resposta = $pedidoController->obterStatusPorIdPedido($dbConnection, $id);
            retornarRespostaJSON($resposta, 200);
            break;

        default:
            echo '{"mensagem": "A ação informada é inválida."}';
            http_response_code(400);
    }
}



function random_string($length)
{
    $str = random_bytes($length);
    $str = base64_encode($str);
    $str = str_replace(["+", "/", "="], "", $str);
    $str = substr($str, 0, $length);
    return $str;
}
