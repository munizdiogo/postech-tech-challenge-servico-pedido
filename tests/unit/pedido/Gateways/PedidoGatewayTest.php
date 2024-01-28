<?php

use Pedido\External\MySqlConnection;
use PHPUnit\Framework\TestCase;
use Pedido\Gateways\PedidoGateway;
use Pedido\Entities\Pedido;

class PedidoGatewayTest extends TestCase
{

    protected $dbConnection;
    protected $pedidoGateway;
    public function setUp(): void
    {
        parent::setUp();
        $this->dbConnection = new MySqlConnection();
        $this->pedidoGateway = new PedidoGateway($this->dbConnection);
    }
    public function testCadastrarPedidoComSucesso()
    {
        $dadosPedidoJSON = '{
            "cpf": "42157363823",
            "produtos": [
                {
                    "id": 2,
                    "nome": "Produto 1",
                    "descricao": "Descrição do Produto 1",
                    "preco": 20.99,
                    "categoria": "lanche"
                },
                 {
                    "id": 3,
                    "nome": "Produto 2",
                    "descricao": "Descrição do Produto 2",
                    "preco": 15.99,
                    "categoria": "bebida"
                }
            ]
        }';

        $dadosPedido = json_decode($dadosPedidoJSON, true);
        $pedido = new Pedido("recebido", $dadosPedido["cpf"], $dadosPedido["produtos"]);
        $resultado = $this->pedidoGateway->cadastrar($pedido);
        $this->assertIsInt($resultado);
        $pedidos = $this->pedidoGateway->buscarPedidosPorCpf("42157363823");
        $pedidoExcluido = $this->pedidoGateway->excluir($pedidos[0]["idPedido"]);
        $this->assertTrue($pedidoExcluido);
    }

    public function testObterPedidosComPedidosExistentes()
    {
        $dadosPedidoJson = '{
            "cpf": "42157363823",
            "produtos": [
                {
                    "id": 2,
                    "nome": "Produto 1",
                    "descricao": "Descrição do Produto 1",
                    "preco": 20.99,
                    "categoria": "lanche"
                },
                 {
                    "id": 3,
                    "nome": "Produto 2",
                    "descricao": "Descrição do Produto 2",
                    "preco": 15.99,
                    "categoria": "bebida"
                }
            ]
        }';

        $dadosPedido = json_decode($dadosPedidoJson, true);
        $pedido = new Pedido("recebido", $dadosPedido["cpf"], $dadosPedido["produtos"]);
        $resultado = $this->pedidoGateway->cadastrar($pedido);
        $this->assertIsInt($resultado);
        $pedidos = $this->pedidoGateway->buscarPedidosPorCpf("42157363823");
        $todosPedidos = $this->pedidoGateway->obterPedidos();
        $this->assertArrayHasKey("idPedido", $todosPedidos[0]);
        $pedidoExcluido = $this->pedidoGateway->excluir($pedidos[0]["idPedido"]);
        $this->assertTrue($pedidoExcluido);
    }

    public function testObterPedidosSemPedidosExistentes()
    {
        $todosPedidos = [];
        $this->assertEquals($todosPedidos, []);
    }
}
