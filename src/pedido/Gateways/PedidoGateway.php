<?php

namespace Pedido\Gateways;

require "./src/pedido/Interfaces/Gateways/PedidoGatewayInterface.php";

use Pedido\Interfaces\DbConnection\DbConnectionInterface;
use Pedido\Interfaces\Gateways\PedidoGatewayInterface;
use Pedido\Entities\Pedido;
use PDOException;

class PedidoGateway implements PedidoGatewayInterface
{
    private $repositorioDados;
    private $nomeTabelaPedidos = "pedidos";
    private $nomeTabelaPedidosProdutos = "pedidos_produtos";

    public function __construct(DbConnectionInterface $database)
    {
        $this->repositorioDados = $database;
    }

    public function cadastrar(Pedido $pedido)
    {
        $parametros = [
            "data_criacao" => date('Y-m-y h:s:i'),
            "status" => $pedido->getStatus(),
            "cpf" => $pedido->getCPF(),
            "pagamento_status" => "pendente",
        ];

        $idPedido = $this->repositorioDados->inserir($this->nomeTabelaPedidos, $parametros);

        if (empty($idPedido)) {
            return false;
        }

        $produtos = $pedido->getProdutos();

        foreach ($produtos as $produto) {
            $parametros = [
                "data_criacao" => date('Y-m-y h:s:i'),
                "pedido_id" => $idPedido,
                "produto_id" => $produto["id"],
                "produto_nome" => $produto["nome"],
                "produto_descricao" => $produto["descricao"],
                "produto_preco" => $produto["preco"],
                "produto_categoria" => $produto["categoria"]
            ];

            $cadastrarProdutoPedido = $this->repositorioDados->inserir($this->nomeTabelaPedidosProdutos, $parametros);
            if (!$cadastrarProdutoPedido) {
                retornarRespostaJSON("Ocorreu um erro ao salvar um item do pedido.", 500);
                die();
            }
        }
        return !empty($idPedido) ? (int)$idPedido : false;
    }
}
