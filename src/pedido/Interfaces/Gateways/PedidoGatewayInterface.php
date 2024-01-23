<?php

namespace Pedido\Interfaces\Gateways;

use Pedido\Entities\Pedido;

interface PedidoGatewayInterface
{
    public function cadastrar(Pedido $pedido);
}
