<?php

namespace Producao\Interfaces\Controllers;

interface PedidoControllerInterface
{
    public function obterPedidos($dbConnection);
    public function atualizarStatusPedido($dbConnection, $id, $status);
}
