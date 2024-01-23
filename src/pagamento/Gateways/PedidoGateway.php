<?php

namespace Pagamento\Gateways;

include_once("./src/pagamento/Interfaces/Gateways/PedidoGatewayInterface.php");

use Pagamento\Interfaces\DbConnection\DbConnectionInterface;
use Pagamento\Interfaces\Gateways\PedidoGatewayInterface;

class PedidoGateway implements PedidoGatewayInterface
{
    private $repositorioDados;
    private $nomeTabelaPedidos = "pedidos";

    public function __construct(DbConnectionInterface $database)
    {
        $this->repositorioDados = $database;
    }

    public function atualizarStatusPagamentoPedido($id, $status): bool
    {
        $parametros = [
            "data_alteracao" => date('Y-m-d H:i:s'),
            "pagamento_status" => $status
        ];
        $resultado = $this->repositorioDados->atualizar($this->nomeTabelaPedidos, $id, $parametros);
        return $resultado;
    }
    public function obterStatusPorIdPedido($id): array
    {
        $campos = ["id", "pagamento_status"];
        $parametros = [
            [
                "campo" => "id",
                "valor" => $id
            ]
        ];
        $resultado = $this->repositorioDados->buscarPorParametros($this->nomeTabelaPedidos, $campos, $parametros);
        return $resultado;
    }
    public function obterPorId($id): array
    {
        $campos = [];
        $parametros = [
            [
                "campo" => "id",
                "valor" => $id
            ]
        ];
        $resultado = $this->repositorioDados->buscarPorParametros($this->nomeTabelaPedidos, $campos, $parametros);
        return $resultado;
    }
}
