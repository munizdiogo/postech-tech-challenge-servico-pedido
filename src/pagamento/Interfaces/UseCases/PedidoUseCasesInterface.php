<?php

namespace Pagamento\Interfaces\UseCases;

use Pagamento\Entities\Pedido;
use Pagamento\Gateways\PedidoGateway;

interface PedidoUseCasesInterface
{
    public function atualizarStatusPagamentoPedido(PedidoGateway $pedidoGateway, int $id, string $status);
    public function obterStatusPorIdPedido(PedidoGateway $pedidoGateway, int $id);
}
