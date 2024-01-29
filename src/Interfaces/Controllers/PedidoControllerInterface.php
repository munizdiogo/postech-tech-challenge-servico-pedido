<?php

namespace Pedido\Interfaces\Controllers;

interface PedidoControllerInterface
{
    public function cadastrar($dbConnection, array $dados);
    public function obterPedidos($dbConnection);
}
