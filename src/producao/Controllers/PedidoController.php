<?php

namespace Producao\Controllers;

require "./src/producao/Interfaces/Controllers/PedidoControllerInterface.php";
require "./src/producao/Gateways/PedidoGateway.php";
require "./src/producao/UseCases/PedidoUseCases.php";

use Producao\Gateways\PedidoGateway;
use Producao\Entities\Pedido;
use Producao\Interfaces\Controllers\PedidoControllerInterface;
use Producao\UseCases\PedidoUseCases;

class PedidoController implements PedidoControllerInterface
{
    public function obterPedidos($dbConnection)
    {
        $pedidoGateway = new PedidoGateway($dbConnection);
        $pedidoUseCases = new PedidoUseCases();
        $pedidos = $pedidoUseCases->obterPedidos($pedidoGateway);
        return $pedidos;
    }
    public function atualizarStatusPedido($dbConnection, $id, $status)
    {
        $pedidoGateway = new PedidoGateway($dbConnection);
        $pedidoUseCases = new PedidoUseCases();
        $resultado = $pedidoUseCases->atualizarStatusPedido($pedidoGateway, $id, $status);
        return $resultado;
    }
}
