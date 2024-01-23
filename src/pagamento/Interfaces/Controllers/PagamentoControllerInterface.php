<?php

namespace Pagamento\Interfaces\Controllers;

interface PagamentoControllerInterface
{
    public function cadastrar($dbConnectionNoSQL, array $dados);
}
