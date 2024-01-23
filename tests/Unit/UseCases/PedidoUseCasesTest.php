<?php

use External\MySqlConnection;
use PHPUnit\Framework\TestCase;
use UseCases\PedidoUseCases;
use Entities\Pedido;
use Gateways\PedidoGateway;

class PedidoUseCasesTest extends TestCase
{
    protected $dbConnectionMock;
    protected $pedidoGatewayMock;
    protected $pedidoUseCasesMock;
    public function setUp(): void
    {
        parent::setUp();
        $this->dbConnectionMock = $this->createMock(MySqlConnection::class);
        $this->pedidoGatewayMock = $this->getMockBuilder(PedidoGateway::class)
            ->setConstructorArgs([$this->dbConnectionMock])
            ->getMock();
        $this->pedidoUseCasesMock = $this->createMock(PedidoUseCases::class);
    }

    public function testCadastrarPedidoComSucesso()
    {
        $produtos = [
            [
                "nome" => "Produto 1",
                "descricao" => "Descrição do Produto 1",
                "preco" => 10.99,
                "categoria" => "Categoria 1"
            ],
            [
                "nome" => "Produto 2",
                "descricao" => "Descrição do Produto 2",
                "preco" => 19.99,
                "categoria" => "Categoria 2"
            ]
        ];

        $pedido = new Pedido("recebido", 1, $produtos);

        $this->pedidoUseCasesMock->expects($this->once())
            ->method('cadastrar')
            ->with(
                $this->equalTo($this->pedidoGatewayMock),
                $this->equalTo($pedido)
            )
            ->willReturn(1);

        $idPedido = $this->pedidoUseCasesMock->cadastrar($this->pedidoGatewayMock, $pedido);
        $this->assertEquals(1, $idPedido);
    }

    public function testCadastrarPedidoComErro()
    {
        $produtos = [
            [
                "nome" => "Produto 1",
                "descricao" => "Descrição do Produto 1",
                "preco" => 10.99,
                "categoria" => "Categoria 1"
            ],
            [
                "nome" => "Produto 2",
                "descricao" => "Descrição do Produto 2",
                "preco" => 19.99,
                "categoria" => "Categoria 2"
            ]
        ];

        $pedido = new Pedido("recebido", 1, $produtos);

        $this->pedidoUseCasesMock->expects($this->once())
            ->method('cadastrar')
            ->with(
                $this->equalTo($this->pedidoGatewayMock),
                $this->equalTo($pedido)
            )
            ->willReturn(false);

        $resultado = $this->pedidoUseCasesMock->cadastrar($this->pedidoGatewayMock, $pedido);
        $this->assertFalse($resultado);
    }
    public function testCadastrarPedidoComCamposFaltando()
    {
        $produtos = [
            [
                "nome" => "Produto 1",
                "descricao" => "Descrição do Produto 1",
                "preco" => 10.99,
                "categoria" => "Categoria 1"
            ],
            [
                "nome" => "Produto 2",
                "descricao" => "Descrição do Produto 2",
                "preco" => 19.99,
                "categoria" => "Categoria 2"
            ]
        ];

        $pedido = new Pedido("recebido", 0, $produtos);

        $this->pedidoUseCasesMock->expects($this->once())
            ->method('cadastrar')
            ->with(
                $this->equalTo($this->pedidoGatewayMock),
                $this->equalTo($pedido)
            )
            ->willReturn('{"mensagem": "O campo cpf é obrigatório."}');

        $resultado = $this->pedidoUseCasesMock->cadastrar($this->pedidoGatewayMock, $pedido);
        $resultadoArray = json_decode($resultado, true);
        $this->assertEquals($resultadoArray["mensagem"], "O campo cpf é obrigatório.");
    }

    public function testObterPedidosComPedidosEncontrados()
    {
        $pedidos = [
            [
                "id" => 1,
                "status" => "recebido"
            ],
            [
                "id" => 2,
                "status" => "recebido"
            ]
        ];

        $this->pedidoUseCasesMock->expects($this->once())
            ->method('obterPedidos')
            ->with($this->pedidoGatewayMock)
            ->willReturn($pedidos);

        $resultado = $this->pedidoUseCasesMock->obterPedidos($this->pedidoGatewayMock);
        $this->assertEquals($pedidos, $resultado);
    }

    public function testObterPedidosSemPedidosEncontrados()
    {
        $this->pedidoUseCasesMock->expects($this->once())
            ->method('obterPedidos')
            ->with($this->pedidoGatewayMock)
            ->willReturn([]);

        $resultado = $this->pedidoUseCasesMock->obterPedidos($this->pedidoGatewayMock);
        $this->assertEquals([], $resultado);
    }

    public function testAtualizarStatusPedidoComSucesso()
    {
        $this->pedidoUseCasesMock->expects($this->once())
            ->method('atualizarStatusPedido')
            ->with(
                $this->equalTo($this->pedidoGatewayMock),
                $this->equalTo(1),
                $this->equalTo("finalizado")
            )
            ->willReturn(true);

        $resultado = $this->pedidoUseCasesMock->atualizarStatusPedido($this->pedidoGatewayMock, 1, "finalizado");
        $this->assertTrue($resultado);
    }
    public function testAtualizarStatusPedidoComErro()
    {
        $this->pedidoUseCasesMock->expects($this->once())
            ->method('atualizarStatusPedido')
            ->with(
                $this->equalTo($this->pedidoGatewayMock),
                $this->equalTo(1),
                $this->equalTo("finalizado")
            )
            ->willReturn(false);

        $resultado = $this->pedidoUseCasesMock->atualizarStatusPedido($this->pedidoGatewayMock, 1, "finalizado");
        $this->assertFalse($resultado);
    }

    public function testAtualizarStatusPedidoComCamposFaltantes()
    {
        $id = 0;
        $this->pedidoUseCasesMock->expects($this->once())
            ->method('atualizarStatusPedido')
            ->with(
                $this->equalTo($this->pedidoGatewayMock),
                $this->equalTo($id),
                $this->equalTo("em_preparacao")
            )
            ->willReturn('{"mensagem": "O campo id é obrigatório."}');

        $resultado = $this->pedidoUseCasesMock->atualizarStatusPedido($this->pedidoGatewayMock, $id, "em_preparacao");
        $resultadoArray = json_decode($resultado, true);
        $this->assertEquals($resultadoArray["mensagem"], "O campo id é obrigatório.");
    }
    public function testAtualizarStatusPedidoComPedidoNaoEncontrado()
    {
        $id = 0;
        $this->pedidoUseCasesMock->expects($this->once())
            ->method('atualizarStatusPedido')
            ->with(
                $this->equalTo($this->pedidoGatewayMock),
                $this->equalTo($id),
                $this->equalTo("em_preparacao")
            )
            ->willReturn('{"mensagem": "Não foi encontrado um pedido com o ID informado."}');

        $resultado = $this->pedidoUseCasesMock->atualizarStatusPedido($this->pedidoGatewayMock, $id, "em_preparacao");
        $resultadoArray = json_decode($resultado, true);
        $this->assertEquals($resultadoArray["mensagem"], "Não foi encontrado um pedido com o ID informado.");
    }

    public function testAtualizarStatusPagamentoPedidoComSucesso()
    {
        $this->pedidoUseCasesMock->expects($this->once())
            ->method('atualizarStatusPagamentoPedido')
            ->with(
                $this->equalTo($this->pedidoGatewayMock),
                $this->equalTo(1),
                $this->equalTo("aprovado")
            )
            ->willReturn(true);

        $resultado = $this->pedidoUseCasesMock->atualizarStatusPagamentoPedido($this->pedidoGatewayMock, 1, "aprovado");
        $this->assertTrue($resultado);
    }

    public function testAtualizarStatusPagamentoPedidoComErro()
    {
        $this->pedidoUseCasesMock->expects($this->once())
            ->method('atualizarStatusPagamentoPedido')
            ->with(
                $this->equalTo($this->pedidoGatewayMock),
                $this->equalTo(1),
                $this->equalTo("aprovado")
            )
            ->willReturn(false);

        $resultado = $this->pedidoUseCasesMock->atualizarStatusPagamentoPedido($this->pedidoGatewayMock, 1, "aprovado");
        $this->assertFalse($resultado);
    }

    public function testAtualizarStatusPagamentoPedidoComCamposFaltando()
    {
        $this->pedidoUseCasesMock->expects($this->once())
            ->method('atualizarStatusPagamentoPedido')
            ->with(
                $this->equalTo($this->pedidoGatewayMock),
                $this->equalTo(0),
                $this->equalTo("aprovado")
            )
            ->willReturn('{"mensagem": "O campo id é obrigatório."}');

        $resultado = $this->pedidoUseCasesMock->atualizarStatusPagamentoPedido($this->pedidoGatewayMock, 0, "aprovado");
        $resultadoArray = json_decode($resultado, true);
        $this->assertEquals($resultadoArray["mensagem"], "O campo id é obrigatório.");
    }

    public function testAtualizarStatusPagamentoPedidoComPedidoNaoEncontrado()
    {
        $this->pedidoUseCasesMock->expects($this->once())
            ->method('atualizarStatusPagamentoPedido')
            ->with(
                $this->equalTo($this->pedidoGatewayMock),
                $this->equalTo(23123123123),
                $this->equalTo("aprovado")
            )
            ->willReturn('{"mensagem": "Não foi encontrado um pedido com o ID informado."}');

        $resultado = $this->pedidoUseCasesMock->atualizarStatusPagamentoPedido($this->pedidoGatewayMock, 23123123123, "aprovado");
        $resultadoArray = json_decode($resultado, true);
        $this->assertEquals($resultadoArray["mensagem"], "Não foi encontrado um pedido com o ID informado.");
    }

    public function testAtualizarStatusPagamentoPedidoComStatusInvalido()
    {
        $this->pedidoUseCasesMock->expects($this->once())
            ->method('atualizarStatusPagamentoPedido')
            ->with(
                $this->equalTo($this->pedidoGatewayMock),
                $this->equalTo(23123123123),
                $this->equalTo("approved")
            )
            ->willReturn('{"mensagem": "O status informado é inválido."}');

        $resultado = $this->pedidoUseCasesMock->atualizarStatusPagamentoPedido($this->pedidoGatewayMock, 23123123123, "approved");
        $resultadoArray = json_decode($resultado, true);
        $this->assertEquals($resultadoArray["mensagem"], "O status informado é inválido.");
    }

    public function testObterStatusPagamentoPedidoComPedidoEncontrado()
    {
        $id = 1;
        $arrayEsperado = [
            "id" => 1,
            "pagamento_status" => "aprovado"
        ];

        $this->pedidoUseCasesMock->expects($this->once())
            ->method('obterStatusPorIdPedido')
            ->with(
                $this->equalTo($this->pedidoGatewayMock),
                $this->equalTo($id)
            )
            ->willReturn($arrayEsperado);

        $resultado = $this->pedidoUseCasesMock->obterStatusPorIdPedido($this->pedidoGatewayMock, $id);
        $this->assertEquals($arrayEsperado, $resultado);
    }

    public function testObterStatusPagamentoPedidoComPedidoNaoEncontrado()
    {
        $id = 1;
        $this->pedidoUseCasesMock->expects($this->once())
            ->method('obterStatusPorIdPedido')
            ->with(
                $this->equalTo($this->pedidoGatewayMock),
                $this->equalTo($id)
            )
            ->willReturn('{"mensagem": "Não foi encontrado um pedido com o ID informado."}');

        $resultado = $this->pedidoUseCasesMock->obterStatusPorIdPedido($this->pedidoGatewayMock, $id);
        $resultadoArray = json_decode($resultado, true);
        $this->assertEquals($resultadoArray["mensagem"], "Não foi encontrado um pedido com o ID informado.");
    }

    public function testObterStatusPagamentoPedidoComCamposFaltando()
    {
        $id = 0;
        $this->pedidoUseCasesMock->expects($this->once())
            ->method('obterStatusPorIdPedido')
            ->with(
                $this->equalTo($this->pedidoGatewayMock),
                $this->equalTo($id)
            )
            ->willReturn('{"mensagem": "O campo id é obrigatório."}');

        $resultado = $this->pedidoUseCasesMock->obterStatusPorIdPedido($this->pedidoGatewayMock, $id);
        $resultadoArray = json_decode($resultado, true);
        $this->assertEquals($resultadoArray["mensagem"], "O campo id é obrigatório.");
    }

    public function testObterPorIdComPedidoEncontrado()
    {
        $id = 1;
        $arrayEsperado = [
            "id" => 1,
            "status" => "em_preparacao"
        ];

        $this->pedidoUseCasesMock->expects($this->once())
            ->method('obterPorId')
            ->with(
                $this->equalTo($this->pedidoGatewayMock),
                $this->equalTo($id)
            )
            ->willReturn($arrayEsperado);

        $resultado = $this->pedidoUseCasesMock->obterPorId($this->pedidoGatewayMock, $id);
        $this->assertEquals($arrayEsperado, $resultado);
    }

    public function testObterPorIdComPedidoNaoEncontrado()
    {
        $id = 1;
        $this->pedidoUseCasesMock->expects($this->once())
            ->method('obterPorId')
            ->with(
                $this->equalTo($this->pedidoGatewayMock),
                $this->equalTo($id)
            )
            ->willReturn([]);

        $resultado = $this->pedidoUseCasesMock->obterPorId($this->pedidoGatewayMock, $id);
        $this->assertEquals([], $resultado);
    }
}
