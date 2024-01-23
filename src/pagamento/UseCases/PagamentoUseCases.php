<?php

namespace Pagamento\UseCases;

require "./src/pagamento/Interfaces/UseCases/PagamentoUseCasesInterface.php";

use Pagamento\Gateways\PagamentoGateway;
use Pagamento\Interfaces\UseCases\PagamentoUseCasesInterface;

class PagamentoUseCases implements PagamentoUseCasesInterface
{
    public function cadastrar(PagamentoGateway $pagamentoGateway, $dados)
    {
        return $pagamentoGateway->cadastrar($dados);
    }
}
