<?php

namespace Controllers;

use Controllers\ProdutoController;
use External\MySqlConnection;
use PHPUnit\Framework\TestCase;

class ProdutoControllerTest extends TestCase
{
    protected $produtoController;
    protected $dbConnectionMock;
    protected $produtoControllerMock;

    public function setUp(): void
    {
        parent::setUp();
        $this->produtoController = new ProdutoController();
        $this->dbConnectionMock = $this->createMock(MySqlConnection::class);
        $this->produtoControllerMock = $this->createMock(ProdutoController::class);
    }

    public function testCadastrarProdutoComSucesso()
    {

        $dadosValidos = [
            'nome' => 'Produto Teste',
            'descricao' => 'Descrição do produto de teste',
            'preco' => 10.99,
            'categoria' => 'Categoria Teste'
        ];

        $this->produtoControllerMock->expects($this->once())
            ->method('cadastrar')
            ->with(
                $this->equalTo($this->dbConnectionMock),
                $this->equalTo($dadosValidos)
            )
            ->willReturn(true);

        $resultado = $this->produtoControllerMock->cadastrar($this->dbConnectionMock, $dadosValidos);
        $this->assertTrue($resultado);
    }

    public function testCadastrarProdutoComErro()
    {
        $dadosValidos = [
            'nome' => 'Produto Teste',
            'descricao' => 'Descrição do produto de teste',
            'preco' => 10.99,
            'categoria' => 'Categoria Teste'
        ];

        $this->produtoControllerMock->expects($this->once())
            ->method('cadastrar')
            ->with(
                $this->equalTo($this->dbConnectionMock),
                $this->equalTo($dadosValidos)
            )
            ->willReturn(false);

        $resultado = $this->produtoControllerMock->cadastrar($this->dbConnectionMock, $dadosValidos);
        $this->assertFalse($resultado);
    }
    public function testCadastrarProdutoComNomeProdutoJaExistente()
    {
        $dadosValidos = [
            'nome' => 'Produto Teste',
            'descricao' => 'Descrição do produto de teste',
            'preco' => 10.99,
            'categoria' => 'Categoria Teste'
        ];

        $this->produtoControllerMock->expects($this->once())
            ->method('cadastrar')
            ->with(
                $this->equalTo($this->dbConnectionMock),
                $this->equalTo($dadosValidos)
            )
            ->willReturn('{"mensagem":"Já existe um produto cadastrado com esse nome."}');

        $resultado = $this->produtoControllerMock->cadastrar($this->dbConnectionMock, $dadosValidos);
        $resultadoArray = json_decode($resultado, true);
        $this->assertEquals(['mensagem' => "Já existe um produto cadastrado com esse nome."], $resultadoArray);
    }

    public function testCadastrarProdutoComCamposFaltando()
    {
        $dadosFaltando = [
            'nome' => 'Produto Teste',
            'descricao' => 'Descrição do produto de teste'
        ];

        $this->produtoControllerMock->expects($this->once())
            ->method('cadastrar')
            ->with(
                $this->equalTo($this->dbConnectionMock),
                $this->equalTo($dadosFaltando)
            )
            ->willReturn('{"mensagem":"O campo \'id\' é obrigatório."}');

        $resultado = $this->produtoControllerMock->cadastrar($this->dbConnectionMock, $dadosFaltando);
        $resultadoArray = json_decode($resultado, true);
        $this->assertEquals(['mensagem' => "O campo 'id' é obrigatório."], $resultadoArray);
    }

    public function testAtualizarProdutoComSucesso()
    {
        $dadosValidos = [
            'id' => 1,
            'nome' => 'Produto Atualizado',
            'descricao' => 'Descrição atualizada',
            'preco' => 19.99,
            'categoria' => 'Categoria Atualizada'
        ];

        $this->produtoControllerMock->expects($this->once())
            ->method('atualizar')
            ->with(
                $this->equalTo($this->dbConnectionMock),
                $this->equalTo($dadosValidos)
            )
            ->willReturn(true);

        $resultado = $this->produtoControllerMock->atualizar($this->dbConnectionMock, $dadosValidos);
        $this->assertTrue($resultado);
    }
    public function testAtualizarProdutoComErro()
    {

        $dadosValidos = [
            'id' => 1,
            'nome' => 'Produto Atualizado',
            'descricao' => 'Descrição atualizada',
            'preco' => 19.99,
            'categoria' => 'Categoria Atualizada'
        ];

        $this->produtoControllerMock->expects($this->once())
            ->method('atualizar')
            ->with(
                $this->equalTo($this->dbConnectionMock),
                $this->equalTo($dadosValidos)
            )
            ->willReturn(false);

        $resultado = $this->produtoControllerMock->atualizar($this->dbConnectionMock, $dadosValidos);
        $this->assertFalse($resultado);
    }
    public function testAtualizarProdutoNaoExistente()
    {
        $dados = [
            'id' => 1,
            'nome' => 'Produto Atualizado',
            'descricao' => 'Descrição atualizada',
            'preco' => 19.99,
            'categoria' => 'Categoria Atualizada'
        ];

        $this->produtoControllerMock->expects($this->once())
            ->method('atualizar')
            ->with(
                $this->equalTo($this->dbConnectionMock),
                $this->equalTo($dados)
            )
            ->willReturn('{"mensagem":"Não foi encontrado um produto com o ID informado."}');

        $resultado = $this->produtoControllerMock->atualizar($this->dbConnectionMock, $dados);
        $resultadoArray = json_decode($resultado, true);
        $this->assertEquals(['mensagem' => "Não foi encontrado um produto com o ID informado."], $resultadoArray);
    }

    public function testExcluirProdutoComSucesso()
    {
        $id = 1;
        $this->produtoControllerMock->expects($this->once())
            ->method('excluir')
            ->with(
                $this->equalTo($this->dbConnectionMock),
                $this->equalTo($id)
            )
            ->willReturn(true);

        $resultado = $this->produtoControllerMock->excluir($this->dbConnectionMock, $id);
        $this->assertTrue($resultado);
    }
    public function testExcluirProdutoComErro()
    {
        $id = 1;
        $this->produtoControllerMock->expects($this->once())
            ->method('excluir')
            ->with(
                $this->equalTo($this->dbConnectionMock),
                $this->equalTo($id)
            )
            ->willReturn(false);

        $resultado = $this->produtoControllerMock->excluir($this->dbConnectionMock, $id);
        $this->assertFalse($resultado);
    }
    public function testExcluirProdutoNaoExistente()
    {
        $id = 1;
        $this->produtoControllerMock->expects($this->once())
            ->method('excluir')
            ->with(
                $this->equalTo($this->dbConnectionMock),
                $this->equalTo($id)
            )
            ->willReturn('{"mensagem":"Não foi encontrado um produto com o ID informado."}');

        $resultado = $this->produtoControllerMock->excluir($this->dbConnectionMock, $id);
        $resultadoArray = json_decode($resultado, true);
        $this->assertEquals(['mensagem' => "Não foi encontrado um produto com o ID informado."], $resultadoArray);
    }
}
