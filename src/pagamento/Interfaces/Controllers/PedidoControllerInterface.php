<?php

namespace Pagamento\Interfaces\Controllers;

interface PedidoControllerInterface
{
    public function obterStatusPorIdPedido($dbConnection, $id);
    public function atualizarStatusPagamentoPedido($dbConnection, $id, $status);
}
