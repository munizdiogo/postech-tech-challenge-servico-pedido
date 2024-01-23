<?php

use External\MySqlConnection;
use PHPUnit\Framework\TestCase;
use Entities\Produto;
use Gateways\ProdutoGateway;
use UseCases\ProdutoUseCases;

class ProdutoUseCasesTest extends TestCase
{
    protected $dbConnectionMock;
    protected $produtoGatewayMock;
    protected $produtoUseCasesMock;

    public function setUp(): void
    {
        parent::setUp();
        $this->dbConnectionMock = $this->createMock(MySqlConnection::class);
        $this->produtoGatewayMock = $this->getMockBuilder(ProdutoGateway::class)
            ->setConstructorArgs([$this->dbConnectionMock])
            ->getMock();
        $this->produtoUseCasesMock = $this->createMock(ProdutoUseCases::class);
    }
    public function testCadastrarProdutoComSucesso()
    {
        $produto = new Produto("Nome do Produto", "Descrição do Produto 1", 25.59, "bebida");
        $this->produtoUseCasesMock->expects($this->once())
            ->method('cadastrar')
            ->with(
                $this->equalTo($this->produtoGatewayMock),
                $this->equalTo($produto)
            )
            ->willReturn(true);

        $resultado = $this->produtoUseCasesMock->cadastrar($this->produtoGatewayMock, $produto);
        $this->assertTrue($resultado);
    }

    public function testCadastrarProdutoComErro()
    {
        $produto = new Produto("Nome do Produto", "Descrição do Produto 1", 25.59, "bebida");
        $this->produtoUseCasesMock->expects($this->once())
            ->method('cadastrar')
            ->with(
                $this->equalTo($this->produtoGatewayMock),
                $this->equalTo($produto)
            )
            ->willReturn(false);

        $resultado = $this->produtoUseCasesMock->cadastrar($this->produtoGatewayMock, $produto);
        $this->assertFalse($resultado);
    }
    public function testCadastrarProdutoComCamposFaltantes()
    {
        $produto = new Produto("Nome do Produto", "Descrição do Produto 1", 25.59, "bebida");
        $this->produtoUseCasesMock->expects($this->once())
            ->method('cadastrar')
            ->with(
                $this->equalTo($this->produtoGatewayMock),
                $this->equalTo($produto)
            )
            ->willReturn('{"mensagem": "O campo nome é obrigatório."}');

        $resultado = $this->produtoUseCasesMock->cadastrar($this->produtoGatewayMock, $produto);
        $resultadoArray = json_decode($resultado, true);
        $this->assertEquals($resultadoArray["mensagem"], "O campo nome é obrigatório.");
    }

    public function testCadastrarProdutoJaExistente()
    {
        $produto = new Produto("Nome do Produto", "Descrição do Produto 1", 25.59, "bebida");
        $this->produtoUseCasesMock->expects($this->once())
            ->method('cadastrar')
            ->with(
                $this->equalTo($this->produtoGatewayMock),
                $this->equalTo($produto)
            )
            ->willReturn('{"mensagem": "Já existe um produto cadastrado com esse nome."}');

        $resultado = $this->produtoUseCasesMock->cadastrar($this->produtoGatewayMock, $produto);
        $resultadoArray = json_decode($resultado, true);
        $this->assertEquals($resultadoArray["mensagem"], "Já existe um produto cadastrado com esse nome.");
    }


    public function testAtualizarProdutoComSucesso()
    {
        $id = 1;
        $produto = new Produto("Novo Nome do Produto", "Nova Descrição do Produto 1", 30.59, "Nova Categoria");
        $this->produtoUseCasesMock->expects($this->once())
            ->method('atualizar')
            ->with(
                $this->equalTo($this->produtoGatewayMock),
                $this->equalTo($id),
                $this->equalTo($produto)
            )
            ->willReturn(true);

        $resultado = $this->produtoUseCasesMock->atualizar($this->produtoGatewayMock, $id, $produto);
        $this->assertTrue($resultado);
    }

    public function testAtualizarProdutoComErro()
    {
        $id = 1;
        $produto = new Produto("Novo Nome do Produto", "Nova Descrição do Produto 1", 30.59, "Nova Categoria");
        $this->produtoUseCasesMock->expects($this->once())
            ->method('atualizar')
            ->with(
                $this->equalTo($this->produtoGatewayMock),
                $this->equalTo($id),
                $this->equalTo($produto)
            )
            ->willReturn(false);

        $resultado = $this->produtoUseCasesMock->atualizar($this->produtoGatewayMock, $id, $produto);
        $this->assertFalse($resultado);
    }

    public function testAtualizarProdutoComCamposFaltando()
    {
        $id = 0;
        $produto = new Produto("Novo Nome do Produto", "Nova Descrição do Produto 1", 30.59, "Nova Categoria");
        $this->produtoUseCasesMock->expects($this->once())
            ->method('atualizar')
            ->with(
                $this->equalTo($this->produtoGatewayMock),
                $this->equalTo($id),
                $this->equalTo($produto)
            )
            ->willReturn('{"mensagem": "O campo id é obrigatório."}');

        $resultado = $this->produtoUseCasesMock->atualizar($this->produtoGatewayMock, $id, $produto);
        $resultadoArray = json_decode($resultado, true);
        $this->assertEquals($resultadoArray["mensagem"], "O campo id é obrigatório.");
    }

    public function testAtualizarProdutoComProdutoNaoEncontrado()
    {
        $id = 1;
        $produto = new Produto("Novo Nome do Produto", "Nova Descrição do Produto 1", 30.59, "Nova Categoria");
        $this->produtoUseCasesMock->expects($this->once())
            ->method('atualizar')
            ->with(
                $this->equalTo($this->produtoGatewayMock),
                $this->equalTo($id),
                $this->equalTo($produto)
            )
            ->willReturn('{"mensagem": "Não foi encontrado um produto com o ID informado."}');

        $resultado = $this->produtoUseCasesMock->atualizar($this->produtoGatewayMock, $id, $produto);
        $resultadoArray = json_decode($resultado, true);
        $this->assertEquals($resultadoArray["mensagem"], "Não foi encontrado um produto com o ID informado.");
    }

    public function testExcluirProdutoComSucesso()
    {
        $id = 1;
        $this->produtoUseCasesMock->expects($this->once())
            ->method('excluir')
            ->with(
                $this->equalTo($this->produtoGatewayMock),
                $this->equalTo($id)
            )
            ->willReturn(true);
        $resultado = $this->produtoUseCasesMock->excluir($this->produtoGatewayMock, $id);
        $this->assertTrue($resultado);
    }

    public function testExcluirProdutoComErro()
    {
        $id = 1;
        $this->produtoUseCasesMock->expects($this->once())
            ->method('excluir')
            ->with(
                $this->equalTo($this->produtoGatewayMock),
                $this->equalTo($id)
            )
            ->willReturn(false);
        $resultado = $this->produtoUseCasesMock->excluir($this->produtoGatewayMock, $id);
        $this->assertFalse($resultado);
    }

    public function testExcluirProdutoComCamposFaltando()
    {
        $id = 0;
        $this->produtoUseCasesMock->expects($this->once())
            ->method('excluir')
            ->with(
                $this->equalTo($this->produtoGatewayMock),
                $this->equalTo($id)
            )
            ->willReturn('{"mensagem": "O campo ID é obrigatório."}');

        $resultado = $this->produtoUseCasesMock->excluir($this->produtoGatewayMock, $id);
        $resultadoArray = json_decode($resultado, true);
        $this->assertEquals($resultadoArray["mensagem"], "O campo ID é obrigatório.");
    }

    public function testExcluirProdutoComProdutoNaoEncontrado()
    {
        $id = 0;
        $this->produtoUseCasesMock->expects($this->once())
            ->method('excluir')
            ->with(
                $this->equalTo($this->produtoGatewayMock),
                $this->equalTo($id)
            )
            ->willReturn('{"mensagem": "Não foi encontrado um produto com o ID informado."}');

        $resultado = $this->produtoUseCasesMock->excluir($this->produtoGatewayMock, $id);
        $resultadoArray = json_decode($resultado, true);
        $this->assertEquals($resultadoArray["mensagem"], "Não foi encontrado um produto com o ID informado.");
    }
    public function testObterPorCategoriaComProdutosEncontrados()
    {
        $categoria = "lanche";

        $json = '[
            {
                "id": "2",
                "data_criacao": "2023-08-23 03:47:02",
                "data_alteracao": null,
                "nome": "Nome do Produto 6",
                "descricao": "Descrição do Produto",
                "preco": "22.99",
                "categoria": "lanche"
            }
        ]';

        $arrayEsperado = json_decode($json, true);

        $this->produtoUseCasesMock->expects($this->once())
            ->method('obterPorCategoria')
            ->with(
                $this->equalTo($this->produtoGatewayMock),
                $this->equalTo($categoria)
            )
            ->willReturn($arrayEsperado);

        $resultado = $this->produtoUseCasesMock->obterPorCategoria($this->produtoGatewayMock, $categoria);
        $this->assertEquals($arrayEsperado, $resultado);
    }
    public function testObterPorCategoriaSemProdutosEncontrados()
    {
        $categoria = "lanche";
        $this->produtoUseCasesMock->expects($this->once())
            ->method('obterPorCategoria')
            ->with(
                $this->equalTo($this->produtoGatewayMock),
                $this->equalTo($categoria)
            )
            ->willReturn([]);

        $resultado = $this->produtoUseCasesMock->obterPorCategoria($this->produtoGatewayMock, $categoria);
        $this->assertEquals([], $resultado);
    }

    public function testObterPorCategoriaCamposFaltantes()
    {
        $categoria = "lanche";
        $this->produtoUseCasesMock->expects($this->once())
            ->method('obterPorCategoria')
            ->with(
                $this->equalTo($this->produtoGatewayMock),
                $this->equalTo($categoria)
            )
            ->willReturn('{"mensagem": "O campo categoria é obrigatório."}');
        $resultado = $this->produtoUseCasesMock->obterPorCategoria($this->produtoGatewayMock, $categoria);
        $resultadoArray = json_decode($resultado, true);
        $this->assertEquals($resultadoArray["mensagem"], "O campo categoria é obrigatório.");
    }
}
