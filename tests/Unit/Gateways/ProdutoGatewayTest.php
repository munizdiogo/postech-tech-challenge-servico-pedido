<?php

use PHPUnit\Framework\TestCase;
use Gateways\ProdutoGateway;
use Interfaces\DbConnection\DbConnectionInterface;
use Entities\Produto;

class ProdutoGatewayTest extends TestCase
{

    private $repositorioDadosMock;


    private $produtoGatewayMock;

    protected function setUp(): void
    {

        $this->repositorioDadosMock = $this->createMock(DbConnectionInterface::class);

        $this->produtoGatewayMock = $this->getMockBuilder(ProdutoGateway::class)
            ->setConstructorArgs([$this->repositorioDadosMock])
            ->getMock();
    }

    public function testCadastrarComSucesso()
    {
        $produto = new Produto('Produto de Teste', 'Descrição de Teste', 10.99, 'Categoria de Teste');
        $this->produtoGatewayMock
            ->expects($this->once())
            ->method('cadastrar')
            ->with($produto)
            ->willReturn(true);

        $resultado = $this->produtoGatewayMock->cadastrar($produto);
        $this->assertTrue($resultado);
    }
    public function testCadastrarComErro()
    {
        $produto = new Produto('Produto de Teste', 'Descrição de Teste', 10.99, 'Categoria de Teste');
        $this->produtoGatewayMock
            ->expects($this->once())
            ->method('cadastrar')
            ->with($produto)
            ->willReturn(false);

        $resultado = $this->produtoGatewayMock->cadastrar($produto);
        $this->assertFalse($resultado);
    }

    public function testAtualizarComSucesso()
    {
        $id = 1;
        $produto = new Produto('Produto Atualizado', 'Descrição Atualizada', 12.99, 'Categoria Atualizada');
        $this->produtoGatewayMock
            ->expects($this->once())
            ->method('atualizar')
            ->with(
                $this->equalTo($id),
                $this->equalTo($produto)
            )
            ->willReturn(true);

        $resultado = $this->produtoGatewayMock->atualizar($id, $produto);
        $this->assertTrue($resultado);
    }

    public function testAtualizarComErro()
    {
        $id = 1;
        $produto = new Produto('Produto Atualizado', 'Descrição Atualizada', 12.99, 'Categoria Atualizada');
        $this->produtoGatewayMock
            ->expects($this->once())
            ->method('atualizar')
            ->with(
                $this->equalTo($id),
                $this->equalTo($produto)
            )
            ->willReturn(false);

        $resultado = $this->produtoGatewayMock->atualizar($id, $produto);
        $this->assertFalse($resultado);
    }

    public function testExcluirComSucesso()
    {
        $id = 1;
        $this->produtoGatewayMock
            ->expects($this->once())
            ->method('excluir')
            ->with($id)
            ->willReturn(true);
        $resultado = $this->produtoGatewayMock->excluir($id);
        $this->assertTrue($resultado);
    }
    public function testExcluirComErro()
    {
        $id = 1;
        $this->produtoGatewayMock
            ->expects($this->once())
            ->method('excluir')
            ->with($id)
            ->willReturn(false);

        $resultado = $this->produtoGatewayMock->excluir($id);
        $this->assertFalse($resultado);
    }

    public function testObterPorNomeComProdutoEncontrado()
    {
        $nome = 'Produto de Teste';
        $this->produtoGatewayMock
            ->expects($this->once())
            ->method('obterPorNome')
            ->with($nome)
            ->willReturn(
                ['id' => 1, 'nome' => 'Produto de Teste', 'descricao' => 'Descrição de Teste']
            );

        $resultado = $this->produtoGatewayMock->obterPorNome($nome);
        $this->assertIsArray($resultado);
        $this->assertEquals('Produto de Teste', $resultado['nome']);
    }

    public function testObterPorNomeComProdutoNaoEncontrado()
    {
        $nome = 'Produto de Teste';
        $this->produtoGatewayMock
            ->expects($this->once())
            ->method('obterPorNome')
            ->with($nome)
            ->willReturn([]);

        $resultado = $this->produtoGatewayMock->obterPorNome($nome);
        $this->assertEquals([], $resultado);
    }

    public function testObterPorIdComProdutoEncontrado()
    {
        $id = 1;
        $this->produtoGatewayMock
            ->expects($this->once())
            ->method('obterPorId')
            ->with($id)
            ->willReturn(
                ['id' => 1, 'nome' => 'Produto de Teste', 'descricao' => 'Descrição de Teste']
            );

        $resultado = $this->produtoGatewayMock->obterPorId($id);
        $this->assertIsArray($resultado);
        $this->assertEquals(1, $resultado['id']);
    }

    public function testObterPorIdComProdutoNaoEncontrado()
    {
        $id = 1;
        $this->produtoGatewayMock
            ->expects($this->once())
            ->method('obterPorId')
            ->with($id)
            ->willReturn([]);

        $resultado = $this->produtoGatewayMock->obterPorId($id);
        $this->assertEquals([], $resultado);
    }

    public function testObterPorCategoriaComProdutosEncontrados()
    {
        $categoria = 'Categoria de Teste';

        $this->produtoGatewayMock
            ->expects($this->once())
            ->method('obterPorCategoria')
            ->with($categoria)
            ->willReturn(
                ['id' => 1, 'nome' => 'Produto de Teste', 'descricao' => 'Descrição de Teste']
            );

        $resultado = $this->produtoGatewayMock->obterPorCategoria($categoria);
        $this->assertIsArray($resultado);
        $this->assertEquals(1, $resultado['id']);
    }
    public function testObterPorCategoriaSemProdutosEncontrados()
    {
        $categoria = 'Categoria de Teste';
        $this->produtoGatewayMock
            ->expects($this->once())
            ->method('obterPorCategoria')
            ->with($categoria)
            ->willReturn([]);

        $resultado = $this->produtoGatewayMock->obterPorCategoria($categoria);
        $this->assertEquals([], $resultado);
    }
}
