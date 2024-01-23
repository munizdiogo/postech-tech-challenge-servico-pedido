<?php

namespace Producao\Interfaces\Gateways;

use Producao\Entities\Pedido;

interface PedidoGatewayInterface
{
    public function cadastrar(Pedido $pedido);
    public function obterPedidos(): array;
    public function atualizarStatusPedido($id, $status): bool;
    public function atualizarStatusPagamentoPedido($id, $status): bool;
    public function obterStatusPorIdPedido($id): array;
    public function obterPorId($id): array;
}
