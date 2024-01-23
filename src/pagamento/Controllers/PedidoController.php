<?php

namespace Pagamento\Controllers;

require "./src/pagamento/Interfaces/Controllers/PedidoControllerInterface.php";
require "./src/pagamento/Gateways/PedidoGateway.php";
require "./src/pagamento/Entities/Pedido.php";
require "./src/pagamento/UseCases/PedidoUseCases.php";

use Pagamento\Gateways\PedidoGateway;
use Pagamento\UseCases\PedidoUseCases;
use Pagamento\Interfaces\Controllers\PedidoControllerInterface;

class PedidoController implements PedidoControllerInterface
{
    public function atualizarStatusPagamentoPedido($dbConnection, $id, $status)
    {
        $pedidoGateway = new PedidoGateway($dbConnection);
        $pedidoUseCases = new PedidoUseCases();
        $resultado = $pedidoUseCases->atualizarStatusPagamentoPedido($pedidoGateway, $id, $status);
        return $resultado;
    }

    public function obterStatusPorIdPedido($dbConnection, $id): array
    {
        $pedidoGateway = new PedidoGateway($dbConnection);
        $pedidoUseCases = new PedidoUseCases();
        $dados = $pedidoUseCases->obterStatusPorIdPedido($pedidoGateway, $id);
        return $dados;
    }
}
