<?php

namespace Pagamento\UseCases;

require "./src/pagamento/Interfaces/UseCases/PedidoUseCasesInterface.php";

use Pagamento\Entities\Pedido;
use Pagamento\Gateways\PedidoGateway;
use Pagamento\Interfaces\UseCases\PedidoUseCasesInterface;

class PedidoUseCases implements PedidoUseCasesInterface
{
    public function atualizarStatusPagamentoPedido(PedidoGateway $pedidoGateway, int $id, string $status)
    {
        $statusPermitidos = ["aprovado", "recusado"];
        $statusValido = in_array($status, $statusPermitidos);
        $pedidoValido = (bool)$pedidoGateway->obterPorId($id);

        if (empty($id)) {
            retornarRespostaJSON("O campo id é obrigatório.", 400);
            die();
        }

        if (empty($status)) {
            retornarRespostaJSON("O campo status é obrigatório.", 400);
            die();
        }

        if (!$pedidoValido) {
            retornarRespostaJSON("Não foi encontrado um pedido com o ID informado.", 400);
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

        $pedidos = $pedidoGateway->atualizarStatusPagamentoPedido($id, $status);
        return $pedidos;
    }
    public function obterStatusPorIdPedido(PedidoGateway $pedidoGateway, int $id)
    {
        if (empty($id)) {
            retornarRespostaJSON("O campo id é obrigatório.", 400);
            die();
        }

        $pedidoValido = (bool)$pedidoGateway->obterPorId($id);

        if (!$pedidoValido) {
            retornarRespostaJSON("Não foi encontrado um pedido com o ID informado.", 400);
            die();
        }

        $pedidos = $pedidoGateway->obterStatusPorIdPedido($id);
        return $pedidos;
    }
}
