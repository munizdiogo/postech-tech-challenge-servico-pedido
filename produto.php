<?php

header('Content-Type: application/json; charset=utf-8');
require "config.php";
require "./src/geral/Utils/RespostasJson.php";
require "./src/produto/External/MySqlConnection.php";
require "./src/produto/Controllers/ProdutoController.php";

use Produto\External\MySqlConnection;
use Produto\Controllers\ProdutoController;

$dbConnection = new MySqlConnection();
$produtoController = new ProdutoController();

if (!empty($_GET["acao"])) {
    switch ($_GET["acao"]) {
        case "cadastrar":
            $salvarDados = $produtoController->cadastrar($dbConnection, $_POST);
            if (!$salvarDados) {
                retornarRespostaJSON("Ocorreu um erro ao salvar os dados do produto.", 500);
                exit;
            }
            retornarRespostaJSON("Produto cadastrado com sucesso.", 201);
            break;

        case "editar":
            $atualizarDados = $produtoController->atualizar($dbConnection, $_POST);
            if (!$atualizarDados) {
                retornarRespostaJSON("Ocorreu um erro ao atualizar os dados do produto.", 500);
                exit;
            }
            retornarRespostaJSON("Produto atualizado com sucesso.", 200);
            break;

        case "excluir":
            $id = $_POST["id"] ?? 0;
            $excluirProduto = $produtoController->excluir($dbConnection, $id);
            if (!$excluirProduto) {
                retornarRespostaJSON("Ocorreu um erro ao excluir o produto.", 500);
                exit;
            }
            retornarRespostaJSON("Produto excluído com sucesso.", 200);
            break;

        case "obterPorCategoria":
            $categoria = $_GET["categoria"] ?? "";
            $produtos = $produtoController->obterPorCategoria($dbConnection, $categoria);
            if (empty($produtos)) {
                retornarRespostaJSON("Nenhum produto encontrado nesta categoria.", 200);
                exit;
            }
            retornarRespostaJSON($produtos, 200);
            break;

        default:
            echo '{"mensagem": "A ação informada é inválida."}';
            http_response_code(400);
    }
}
