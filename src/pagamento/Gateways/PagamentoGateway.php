<?php

namespace Pagamento\Gateways;

require "./src/pagamento/Interfaces/Gateways/PagamentoGatewayInterface.php";

use Pagamento\Interfaces\DbConnection\DbConnectionNoSQLInterface;
use Pagamento\Interfaces\Gateways\PagamentoGatewayInterface;

class PagamentoGateway implements PagamentoGatewayInterface
{
    private $repositorioDados;
    private $nomeTabelaPagamentos = "pagamentos";
    public function __construct(DbConnectionNoSQLInterface $database)
    {
        $this->repositorioDados = $database;
    }

    public function cadastrar($dados)
    {
        $cadastrarPagamento = $this->repositorioDados->inserir($this->nomeTabelaPagamentos, $dados);
        if (!$cadastrarPagamento) {
            retornarRespostaJSON("Ocorreu um erro ao registrar dados do pagamento.", 500);
            die();
        }
        return $cadastrarPagamento;
    }
}
