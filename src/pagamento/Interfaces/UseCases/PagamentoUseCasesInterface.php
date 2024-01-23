<?php

namespace Pagamento\Interfaces\UseCases;

use Pagamento\Entities\Pedido;
use Pagamento\Gateways\PagamentoGateway;

interface PagamentoUseCasesInterface
{
    public function cadastrar(PagamentoGateway $pagamentoGateway, Array $dados);
    // public function obterPedidos(PedidoGateway $pedidoGateway);
    // public function atualizarStatusPedido(PedidoGateway $pedidoGateway, int $id, string $status);
    // public function atualizarStatusPagamentoPedido(PedidoGateway $pedidoGateway, int $id, string $status);
    // public function obterStatusPorIdPedido(PedidoGateway $pedidoGateway, int $id);
    // public function obterPorId(PedidoGateway $pedidoGateway, int $id);
}
