<?php

use Pedido\External\MySqlConnection;
use PHPUnit\Framework\TestCase;
use Pedido\UseCases\PedidoUseCases;
use Pedido\Entities\Pedido;
use Pedido\Gateways\PedidoGateway;

class PedidoUseCasesTest extends TestCase
{
    protected $dbConnection;
    protected $pedidoGateway;
    protected $pedidoUseCases;
    public function setUp(): void
    {
        parent::setUp();
        $this->dbConnection = new MySqlConnection;
        $this->pedidoGateway =  new PedidoGateway($this->dbConnection);
        $this->pedidoUseCases = new PedidoUseCases;
    }

    public function testCadastrarPedidoComSucesso()
    {
        $produtos = [
            [
                "id" => 1,
                "nome" => "Produto 1",
                "descricao" => "Descrição do Produto 1",
                "preco" => 10.99,
                "categoria" => "Categoria 1"
            ],
            [
                "id" => 2,
                "nome" => "Produto 2",
                "descricao" => "Descrição do Produto 2",
                "preco" => 19.99,
                "categoria" => "Categoria 2"
            ]
        ];

        $pedido = new Pedido("recebido", "42157363823", $produtos);
        $idPedido = $this->pedidoUseCases->cadastrar($this->pedidoGateway, $pedido);
        $this->assertIsInt($idPedido);
        $pedidos = $this->pedidoUseCases->buscarPedidosPorCpf($this->pedidoGateway, "42157363823");
        $pedidoProdutosExcluido = $this->pedidoUseCases->excluirProdutos($this->pedidoGateway,  $pedidos[0]["idPedido"]);
        $this->assertTrue($pedidoProdutosExcluido);
        $pedidoExcluido = $this->pedidoUseCases->excluir($this->pedidoGateway,  $pedidos[0]["idPedido"]);
        $this->assertTrue($pedidoExcluido);
    }

    public function testCadastrarPedidoComCamposFaltando()
    {
        try {
            $produtos = [
                [
                    "id" => 1,
                    "nome" => "Produto 1",
                    "descricao" => "Descrição do Produto 1",
                    "preco" => 10.99,
                    "categoria" => "Categoria 1"
                ],
                [
                    "id" => 2,
                    "nome" => "Produto 2",
                    "descricao" => "Descrição do Produto 2",
                    "preco" => 19.99,
                    "categoria" => "Categoria 2"
                ]
            ];
            $pedido = new Pedido("recebido", "", $produtos);
            $this->pedidoUseCases->cadastrar($this->pedidoGateway, $pedido);
        } catch (\Exception $e) {
            $this->assertEquals("O campo cpf é obrigatório.", $e->getMessage());
            $this->assertEquals(400, $e->getCode());
        }
    }

    public function testObterPedidosComPedidosEncontrados()
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

        $pedidoArray = json_decode($dadosPedido, true);
        $pedido = new Pedido("recebido", "42157363823", $pedidoArray["produtos"]);
        $resultado = $this->pedidoUseCases->cadastrar($this->pedidoGateway, $pedido);
        $this->assertIsInt($resultado);
        $pedidos = $this->pedidoUseCases->buscarPedidosPorCpf($this->pedidoGateway, "42157363823");
        $todosPedidos = $this->pedidoUseCases->obterPedidos($this->pedidoGateway);
        $this->assertArrayHasKey("idPedido", $todosPedidos[0]);
        $pedidoExcluido = $this->pedidoUseCases->excluir($this->pedidoGateway,  $pedidos[0]["idPedido"]);
        $this->assertTrue($pedidoExcluido);
    }
    public function testObterStatusPorIdPedido()
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

        $pedidoArray = json_decode($dadosPedido, true);
        $pedido = new Pedido("recebido", "42157363823", $pedidoArray["produtos"]);
        $resultado = $this->pedidoUseCases->cadastrar($this->pedidoGateway, $pedido);
        $this->assertIsInt($resultado);
        $pedidos = $this->pedidoUseCases->buscarPedidosPorCpf($this->pedidoGateway, "42157363823");
        $todosPedidos = $this->pedidoUseCases->obterStatusPorIdPedido($this->pedidoGateway, $pedidos[0]["idPedido"]);
        $this->assertArrayHasKey("id", $todosPedidos[0]);
        $pedidoExcluido = $this->pedidoUseCases->excluir($this->pedidoGateway, $pedidos[0]["idPedido"]);
        $this->assertTrue($pedidoExcluido);
    }
    public function testObterStatusPorIdPedidoComIdNaoEncontrado()
    {
        try {
            $this->pedidoUseCases->obterStatusPorIdPedido($this->pedidoGateway, 99999999999);
        } catch (\Exception $e) {
            $this->assertEquals("Não foi encontrado um pedido com o ID informado.", $e->getMessage());
            $this->assertEquals(400, $e->getCode());
        }
    }
    public function testObterStatusPorIdPedidoComIdNaoInformado()
    {
        try {
            $this->pedidoUseCases->obterStatusPorIdPedido($this->pedidoGateway, 0);
        } catch (\Exception $e) {
            $this->assertEquals("O campo id é obrigatório.", $e->getMessage());
            $this->assertEquals(400, $e->getCode());
        }
    }

    public function testObterPedidosSemPedidosEncontrados()
    {
        $todosPedidos = [];
        $this->assertEquals($todosPedidos, []);
    }

    public function testAtualizarStatusPagamentoPedidoComSucesso()
    {
        $produtos = [
            [
                "id" => 1,
                "nome" => "Produto 1",
                "descricao" => "Descrição do Produto 1",
                "preco" => 10.99,
                "categoria" => "Categoria 1"
            ],
            [
                "id" => 2,
                "nome" => "Produto 2",
                "descricao" => "Descrição do Produto 2",
                "preco" => 19.99,
                "categoria" => "Categoria 2"
            ]
        ];

        $pedido = new Pedido("recebido", "42157363823", $produtos);
        $idPedido = $this->pedidoUseCases->cadastrar($this->pedidoGateway, $pedido);
        $this->assertIsInt($idPedido);
        $pedidos = $this->pedidoUseCases->buscarPedidosPorCpf($this->pedidoGateway, "42157363823");
        $pedidoProdutosExcluido = $this->pedidoUseCases->atualizarStatusPagamentoPedido($this->pedidoGateway, $pedidos[0]["idPedido"], "aprovado");
        $this->assertTrue($pedidoProdutosExcluido);
        $pedidoExcluido = $this->pedidoUseCases->excluir($this->pedidoGateway,  $pedidos[0]["idPedido"]);
        $this->assertTrue($pedidoExcluido);
    }
    public function testAtualizarStatusPagamentoPedidoComIdFaltando()
    {
        try {
            $produtos = [
                [
                    "id" => 1,
                    "nome" => "Produto 1",
                    "descricao" => "Descrição do Produto 1",
                    "preco" => 10.99,
                    "categoria" => "Categoria 1"
                ],
                [
                    "id" => 2,
                    "nome" => "Produto 2",
                    "descricao" => "Descrição do Produto 2",
                    "preco" => 19.99,
                    "categoria" => "Categoria 2"
                ]
            ];

            $pedido = new Pedido("recebido", "42157363823", $produtos);
            $idPedido = $this->pedidoUseCases->cadastrar($this->pedidoGateway, $pedido);
            $this->assertIsInt($idPedido);
            $pedidos = $this->pedidoUseCases->buscarPedidosPorCpf($this->pedidoGateway, "42157363823");
            $pedidoProdutosExcluido = $this->pedidoUseCases->atualizarStatusPagamentoPedido($this->pedidoGateway, 0, "aprovado");
            $this->assertTrue($pedidoProdutosExcluido);
        } catch (\Exception $e) {
            $this->assertEquals("O campo id é obrigatório.", $e->getMessage());
            $this->assertEquals(400, $e->getCode());
            $pedidoExcluido = $this->pedidoUseCases->excluir($this->pedidoGateway,  $pedidos[0]["idPedido"]);
            $this->assertTrue($pedidoExcluido);
        }
    }
    public function testAtualizarStatusPagamentoPedidoComStatusFaltando()
    {
        try {
            $produtos = [
                [
                    "id" => 1,
                    "nome" => "Produto 1",
                    "descricao" => "Descrição do Produto 1",
                    "preco" => 10.99,
                    "categoria" => "Categoria 1"
                ],
                [
                    "id" => 2,
                    "nome" => "Produto 2",
                    "descricao" => "Descrição do Produto 2",
                    "preco" => 19.99,
                    "categoria" => "Categoria 2"
                ]
            ];

            $pedido = new Pedido("recebido", "42157363823", $produtos);
            $idPedido = $this->pedidoUseCases->cadastrar($this->pedidoGateway, $pedido);
            $this->assertIsInt($idPedido);
            $pedidos = $this->pedidoUseCases->buscarPedidosPorCpf($this->pedidoGateway, "42157363823");
            $pedidoProdutosExcluido = $this->pedidoUseCases->atualizarStatusPagamentoPedido($this->pedidoGateway, $pedidos[0]["idPedido"], "");
            $this->assertTrue($pedidoProdutosExcluido);
        } catch (\Exception $e) {
            $this->assertEquals("O campo status é obrigatório.", $e->getMessage());
            $this->assertEquals(400, $e->getCode());
            $pedidoExcluido = $this->pedidoUseCases->excluir($this->pedidoGateway,  $pedidos[0]["idPedido"]);
            $this->assertTrue($pedidoExcluido);
        }
    }
    public function testAtualizarStatusPagamentoPedidoComStatusInvalido()
    {
        try {
            $produtos = [
                [
                    "id" => 1,
                    "nome" => "Produto 1",
                    "descricao" => "Descrição do Produto 1",
                    "preco" => 10.99,
                    "categoria" => "Categoria 1"
                ],
                [
                    "id" => 2,
                    "nome" => "Produto 2",
                    "descricao" => "Descrição do Produto 2",
                    "preco" => 19.99,
                    "categoria" => "Categoria 2"
                ]
            ];

            $pedido = new Pedido("recebido", "42157363823", $produtos);
            $idPedido = $this->pedidoUseCases->cadastrar($this->pedidoGateway, $pedido);
            $this->assertIsInt($idPedido);
            $pedidos = $this->pedidoUseCases->buscarPedidosPorCpf($this->pedidoGateway, "42157363823");
            $pedidoProdutosExcluido = $this->pedidoUseCases->atualizarStatusPagamentoPedido($this->pedidoGateway, $pedidos[0]["idPedido"], "approved");
            $this->assertTrue($pedidoProdutosExcluido);
        } catch (\Exception $e) {
            $this->assertEquals("O status informado é inválido.", $e->getMessage());
            $this->assertEquals(400, $e->getCode());
            $pedidoExcluido = $this->pedidoUseCases->excluir($this->pedidoGateway,  $pedidos[0]["idPedido"]);
            $this->assertTrue($pedidoExcluido);
        }
    }
    public function testAtualizarStatusPagamentoPedidoComIdNaoEncontrado()
    {
        try {
            $this->pedidoUseCases->atualizarStatusPagamentoPedido($this->pedidoGateway, 99999999999, "aprovado");
        } catch (\Exception $e) {
            $this->assertEquals("Não foi encontrado um pedido com o ID informado.", $e->getMessage());
            $this->assertEquals(400, $e->getCode());
        }
    }
}
