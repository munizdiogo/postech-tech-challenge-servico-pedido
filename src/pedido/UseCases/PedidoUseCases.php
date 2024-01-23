<?php

namespace Pedido\UseCases;

require "./src/pedido/Interfaces/UseCases/PedidoUseCasesInterface.php";

use Pedido\Entities\Pedido;
use Pedido\Gateways\PedidoGateway;
use Pedido\Interfaces\UseCases\PedidoUseCasesInterface;

class PedidoUseCases implements PedidoUseCasesInterface
{
    public function cadastrar(PedidoGateway $pedidoGateway, Pedido $pedido)
    {
        if (empty($pedido->getCPF())) {
            retornarRespostaJSON("O campo cpf é obrigatório.", 400);
            die();
        }

        if (empty($pedido->getProdutos())) {
            retornarRespostaJSON("O campo produtos é obrigatório.", 400);
            die();
        }

        $idPedido = $pedidoGateway->cadastrar($pedido);
        return $idPedido;
    }
}
