<?php

use External\MySqlConnection;
use PHPUnit\Framework\TestCase;
use Gateways\PedidoGateway;
use Entities\Pedido;

class PedidoGatewayTest extends TestCase
{

    protected $dbConnectionMock;
    protected $pedidoGatewayMock;
    public function setUp(): void
    {
        parent::setUp();
        $this->dbConnectionMock = $this->createMock(MySqlConnection::class);
        $this->pedidoGatewayMock = $this->getMockBuilder(PedidoGateway::class)
            ->setConstructorArgs([$this->dbConnectionMock])
            ->getMock();
    }
    public function testCadastrarPedidoComSucesso()
    {
        $produtos = [
            [
                "id" => 1,
                "nome" => "Produto de Teste 1",
                "descricao" => "Descrição do Produto de Teste 1",
                "preco" => 19.99,
                "categoria" => "Categoria de Teste 1"
            ],
            [
                "id" => 2,
                "nome" => "Produto de Teste 2",
                "descricao" => "Descrição do Produto de Teste 2",
                "preco" => 20.99,
                "categoria" => "Categoria de Teste 2"
            ]
        ];

        $pedido = new Pedido("recebido", 1, $produtos);

        $this->pedidoGatewayMock->expects($this->once())
            ->method('cadastrar')
            ->with($pedido)
            ->willReturn(123);


        $resultado = $this->pedidoGatewayMock->cadastrar($pedido);


        $this->assertNotEmpty($resultado);
        $this->assertIsInt($resultado);
    }

    public function testCadastrarPedidoComErro()
    {
        $produtos = [
            [
                "id" => 1,
                "nome" => "Produto de Teste 1",
                "descricao" => "Descrição do Produto de Teste 1",
                "preco" => 19.99,
                "categoria" => "Categoria de Teste 1"
            ],
            [
                "id" => 2,
                "nome" => "Produto de Teste 2",
                "descricao" => "Descrição do Produto de Teste 2",
                "preco" => 20.99,
                "categoria" => "Categoria de Teste 2"
            ]
        ];

        $pedido = new Pedido("recebido", 1, $produtos);

        $this->pedidoGatewayMock->expects($this->once())
            ->method('cadastrar')
            ->with($pedido)
            ->willReturn(false);


        $resultado = $this->pedidoGatewayMock->cadastrar($pedido);
        $this->assertFalse($resultado);
    }
    public function testCadastrarPedidoComErroAoSalvarItemDoPedido()
    {
        $produtos = [
            [
                "id" => 1,
                "nome" => "Produto de Teste 1",
                "descricao" => "Descrição do Produto de Teste 1",
                "preco" => 19.99,
                "categoria" => "Categoria de Teste 1"
            ],
            [
                "id" => 2,
                "nome" => "Produto de Teste 2",
                "descricao" => "Descrição do Produto de Teste 2",
                "preco" => 20.99,
                "categoria" => "Categoria de Teste 2"
            ]
        ];

        $pedido = new Pedido("recebido", 1, $produtos);

        $this->pedidoGatewayMock->expects($this->once())
            ->method('cadastrar')
            ->with($pedido)
            ->willReturn('{"mensagem":"Ocorreu um erro ao salvar um item do pedido."}');
        $resultado = $this->pedidoGatewayMock->cadastrar($pedido);
        $resultadoArray = json_decode($resultado, true);
        $this->assertEquals(['mensagem' => "Ocorreu um erro ao salvar um item do pedido."], $resultadoArray);
    }

    public function testObterPedidosComPedidosEncontrados()
    {
        $json = '[
                {
                    "idPedido": 1,
                    "dataCriacao": "2023-09-23 11:14:02",
                    "dataAlteracao": "2023-09-23 11:07:11",
                    "status": "em_preparacao",
                    "statusPagamento": "aprovado",
                    "qtdProdutos": 2,
                    "precoTotal": "36.98",
                    "produtos": [
                        {
                            "id": 2,
                            "nome": "Produto 1",
                            "descricao": "Descrição do Produto 1",
                            "preco": "20.99",
                            "categoria": "lanche"
                        },
                        {
                            "id": 3,
                            "nome": "Produto 2",
                            "descricao": "Descrição do Produto 2",
                            "preco": "15.99",
                            "categoria": "bebida"
                        }
                    ]
                },
                {
                    "idPedido": 2,
                    "dataCriacao": "2023-09-23 11:26:02",
                    "dataAlteracao": null,
                    "status": "recebido",
                    "statusPagamento": null,
                    "qtdProdutos": 2,
                    "precoTotal": "36.98",
                    "produtos": [
                        {
                            "id": 2,
                            "nome": "Produto 1",
                            "descricao": "Descrição do Produto 1",
                            "preco": "20.99",
                            "categoria": "lanche"
                        },
                        {
                            "id": 3,
                            "nome": "Produto 2",
                            "descricao": "Descrição do Produto 2",
                            "preco": "15.99",
                            "categoria": "bebida"
                        }
                    ]
                }
            ]';

        $arrayEsperado = json_decode($json, true);

        $this->pedidoGatewayMock->expects($this->once())
            ->method('obterPedidos')
            ->willReturn($arrayEsperado);


        $pedidos = $this->pedidoGatewayMock->obterPedidos();


        $this->assertNotEmpty($pedidos);
        $this->assertIsArray($pedidos);


        $this->assertArrayHasKey("idPedido", $pedidos[0]);
        $this->assertArrayHasKey("dataCriacao", $pedidos[0]);
        $this->assertArrayHasKey("status", $pedidos[0]);
    }

    public function testObterPedidosSemPedidosEncontrados()
    {
        $this->pedidoGatewayMock->expects($this->once())
            ->method('obterPedidos')
            ->willReturn([]);

        $resultado = $this->pedidoGatewayMock->obterPedidos();
        $this->assertEquals([], $resultado);
    }

    public function testAtualizarStatusPedidoComSucesso()
    {
        $this->pedidoGatewayMock->expects($this->once())
            ->method('atualizarStatusPedido')
            ->with(
                $this->equalTo(1),
                $this->equalTo("finalizado")
            )
            ->willReturn(true);

        $resultado = $this->pedidoGatewayMock->atualizarStatusPedido(1, "finalizado");
        $this->assertTrue($resultado);
    }
    public function testAtualizarStatusPedidoComErro()
    {
        $this->pedidoGatewayMock->expects($this->once())
            ->method('atualizarStatusPedido')
            ->with(
                $this->equalTo(1),
                $this->equalTo("finalizado")
            )
            ->willReturn(false);

        $resultado = $this->pedidoGatewayMock->atualizarStatusPedido(1, "finalizado");
        $this->assertFalse($resultado);
    }

    public function testAtualizarStatusPagamentoPedidoComSucesso()
    {
        $this->pedidoGatewayMock->expects($this->once())
            ->method('atualizarStatusPagamentoPedido')
            ->with(
                $this->equalTo(1),
                $this->equalTo("aprovado")
            )
            ->willReturn(true);

        $resultado = $this->pedidoGatewayMock->atualizarStatusPagamentoPedido(1, "aprovado");
        $this->assertTrue($resultado);
    }
    public function testAtualizarStatusPagamentoPedidoComErro()
    {
        $this->pedidoGatewayMock->expects($this->once())
            ->method('atualizarStatusPagamentoPedido')
            ->with(
                $this->equalTo(1),
                $this->equalTo("aprovado")
            )
            ->willReturn(false);

        $resultado = $this->pedidoGatewayMock->atualizarStatusPagamentoPedido(1, "aprovado");
        $this->assertFalse($resultado);
    }

    public function testObterStatusPagamentoPedidoComPedidoEncontrado()
    {
        $arrayEsperado = [
            "id" => 1,
            "pagamento_status" => "aprovado"
        ];

        $this->pedidoGatewayMock->expects($this->once())
            ->method('obterStatusPorIdPedido')
            ->with(1)
            ->willReturn($arrayEsperado);


        $resultado = $this->pedidoGatewayMock->obterStatusPorIdPedido(1);
        $this->assertIsArray($resultado);
        $this->assertArrayHasKey("id", $resultado);
        $this->assertArrayHasKey("pagamento_status", $resultado);
    }
    public function testObterStatusPagamentoPedidoComPedidoNaoEncontrado()
    {
        $this->pedidoGatewayMock->expects($this->once())
            ->method('obterStatusPorIdPedido')
            ->with(1)
            ->willReturn([]);
        $resultado = $this->pedidoGatewayMock->obterStatusPorIdPedido(1);
        $this->assertEquals([], $resultado);
    }

    public function testObterPorIdComPedidoEncontrado()
    {
        $arrayEsperado = [
            "id" => 1,
            "data_criacao" => "2023-08-28 04:00:00",
            "data_alteracao" => null,
            "status" => "em_preparacao",
            "cpf" => 2,
            "pagamento_status" => "pendente"
        ];

        $this->pedidoGatewayMock->expects($this->once())
            ->method('obterPorId')
            ->with(1)
            ->willReturn($arrayEsperado);


        $resultado = $this->pedidoGatewayMock->obterPorId(1);


        $this->assertEquals($arrayEsperado, $resultado);
    }
    public function testObterPorIdComPedidoNaoEncontrado()
    {
        $this->pedidoGatewayMock->expects($this->once())
            ->method('obterPorId')
            ->with(1)
            ->willReturn([]);

        $resultado = $this->pedidoGatewayMock->obterPorId(1);
        $this->assertEquals([], $resultado);
    }
}
