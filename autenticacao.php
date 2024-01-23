<?php

header('Content-Type: application/json; charset=utf-8');

require "./src/autenticacao/Controllers/AutenticacaoController.php";

use Autenticacao\Controllers\AutenticacaoController;

$autenticacaoController = new AutenticacaoController();

if (!empty($_GET["acao"])) {
    switch ($_GET["acao"]) {
        case 'gerarToken':

            if (empty($_POST['cpf'])) {
                retornarRespostaJSON("É obrigatório informar o CPF", 401);
                die();
            }

            $cpf = $_POST['cpf'] ?? '';

            echo $autenticacaoController->gerarToken($cpf);
            break;
        case 'criarConta':

            if (empty($_POST['cpf'])) {
                retornarRespostaJSON("É obrigatório informar o CPF", 401);
                die();
            }

            $cpf = $_POST['cpf'] ?? '';
            $nome = $_POST['nome'] ?? '';
            $email = $_POST['email'] ?? '';

            echo $autenticacaoController->criarContaCognito($cpf, $nome, $email);
            break;

        default:
            echo '{"mensagem": "A ação informada é inválida."}';
            http_response_code(400);
    }
}
