<?php

namespace Pedido\Controllers;

require "./src/Controllers/PedidoController.php";
require "./src/External/MySqlConnection.php";

use Pedido\Controllers\PedidoController;
use Pedido\External\MySqlConnection;
use PHPUnit\Framework\TestCase;

class PedidoControllerTest extends TestCase
{
    protected $pedidoController;
    protected $dbConnection;

    public function setUp(): void
    {
        parent::setUp();
        $this->pedidoController = new PedidoController();
        $this->dbConnection = new MySqlConnection;
    }

    public function testCadastrarPedidoComSucesso()
    {
        $dadosPedido = '{
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

        $dadosValidos = json_decode($dadosPedido, true);
        $resultado = $this->pedidoController->cadastrar($this->dbConnection, $dadosValidos);
        $this->assertIsInt($resultado);
        $pedidos = $this->pedidoController->buscarPedidosPorCpf($this->dbConnection, "42157363823");
        $pedidoExcluido = $this->pedidoController->excluir($this->dbConnection,  $pedidos[0]["idPedido"]);
        $this->assertTrue($pedidoExcluido);
    }
    public function testCadastrarPedidoComCamposFaltando()
    {
        $json = '{
            "cpf": 1
        }';

        $dadosPedido = json_decode($json, true);

        try {
            $this->pedidoController->cadastrar($this->dbConnection, $dadosPedido);
        } catch (\Exception $e) {
            $this->assertEquals("O campo produtos é obrigatório.", $e->getMessage());
            $this->assertEquals(400, $e->getCode());
        }
    }

    public function testObterPedidosComPedidosExistentes()
    {
        $json = '{
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

        $dadosValidos = json_decode($json, true);
        $resultado = $this->pedidoController->cadastrar($this->dbConnection, $dadosValidos);
        $this->assertIsInt($resultado);
        $pedidos = $this->pedidoController->buscarPedidosPorCpf($this->dbConnection, "42157363823");
        $todosPedidos = $this->pedidoController->obterPedidos($this->dbConnection);
        $this->assertArrayHasKey("idPedido", $todosPedidos[0]);
        $pedidoExcluido = $this->pedidoController->excluir($this->dbConnection,  $pedidos[0]["idPedido"]);
        $this->assertTrue($pedidoExcluido);
    }

    public function testObterPedidosSemPedidosExistentes()
    {
        $todosPedidos = [];
        $this->assertEquals($todosPedidos, []);
    }
}
