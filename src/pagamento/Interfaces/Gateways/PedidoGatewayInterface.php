<?php

namespace Pagamento\Interfaces\Gateways;

interface PedidoGatewayInterface
{
    public function atualizarStatusPagamentoPedido($id, $status): bool;
    public function obterStatusPorIdPedido($id): array;
    public function obterPorId($id): array;
}
