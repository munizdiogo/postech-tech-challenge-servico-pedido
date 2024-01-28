<?php

namespace Pedido\Interfaces\UseCases;

use Pedido\Entities\Pedido;
use Pedido\Gateways\PedidoGateway;

interface PedidoUseCasesInterface
{
    public function cadastrar(PedidoGateway $pedidoGateway, Pedido $pedido);
    public function obterPedidos(PedidoGateway $pedidoGateway);
}
