<?php

namespace Pedido\Controllers;

require "./src/pedido/Interfaces/Controllers/PedidoControllerInterface.php";
require "./src/pedido/UseCases/PedidoUseCases.php";
require "./src/pedido/Gateways/PedidoGateway.php";
require "./src/pedido/Entities/Pedido.php";

use Pedido\Gateways\PedidoGateway;
use Pedido\Entities\Pedido;
use Pedido\Interfaces\Controllers\PedidoControllerInterface;
use Pedido\UseCases\PedidoUseCases;

class PedidoController implements PedidoControllerInterface
{
    public function cadastrar($dbConnection, array $dados)
    {
        $dados = $dados ?? [];
        $cpf = $dados["cpf"] ?? "";
        $produtos = $dados["produtos"] ?? [];
        $pedidoGateway = new PedidoGateway($dbConnection);
        $pedidoUseCases = new PedidoUseCases();
        $pedido = new Pedido("recebido", $cpf, $produtos);
        $idPedido = $pedidoUseCases->cadastrar($pedidoGateway, $pedido);
        return $idPedido;
    }
}
