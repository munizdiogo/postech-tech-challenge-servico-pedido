<?php

namespace Producao\UseCases;

require "./src/producao/Interfaces/UseCases/PedidoUseCasesInterface.php";
require "./src/producao/Entities/Pedido.php";

use Producao\Entities\Pedido;
use Producao\Gateways\PedidoGateway;
use Producao\Interfaces\UseCases\PedidoUseCasesInterface;

class PedidoUseCases implements PedidoUseCasesInterface
{
    public function obterPedidos(PedidoGateway $pedidoGateway)
    {
        $pedidos = $pedidoGateway->obterPedidos();
        return $pedidos;
    }

    public function atualizarStatusPedido(PedidoGateway $pedidoGateway, int $id, string $status)
    {
        $statusPermitidos = ["recebido", "em_preparacao", "pronto", "finalizado"];
        $statusValido = in_array($status, $statusPermitidos);

        if (empty($id)) {
            retornarRespostaJSON("O campo id é obrigatório.", 400);
            die();
        }

        if (!$statusValido) {
            retornarRespostaJSON("O status informado é inválido.", 400);
            die();
        }

        $pedidoValido = (bool)$pedidoGateway->obterPorId($id);
        if (!$pedidoValido) {
            retornarRespostaJSON("Não foi encontrado um pedido com o ID informado.", 400);
            die();
        }

        $pedidos = $pedidoGateway->atualizarStatusPedido($id, $status);
        return $pedidos;
    }
}
