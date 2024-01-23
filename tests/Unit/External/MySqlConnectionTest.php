<?php

use PHPUnit\Framework\TestCase;
use External\MySqlConnection;

class MySqlConnectionTest extends TestCase
{
    protected $dbConnectionMock;
    protected $pdoMock;
    public function setUp(): void
    {
        parent::setUp();
        $this->dbConnectionMock = $this->createMock(MySqlConnection::class);
        $this->pdoMock = $this->createMock(PDO::class);
    }

    public function testConectarComSucesso()
    {
        $this->dbConnectionMock->expects($this->once())
            ->method('conectar')
            ->willReturn($this->pdoMock);
        $conn = $this->dbConnectionMock->conectar();
        $this->assertInstanceOf(PDO::class, $conn);
    }
    public function testConectarComErro()
    {
        $this->dbConnectionMock->expects($this->once())
            ->method('conectar')
            ->willReturn(null);
        $conn = $this->dbConnectionMock->conectar();
        $this->assertNull($conn);
    }
    public function testInserirComSucesso()
    {
        $dadosInsercao = [
            'campo1' => 'valor1',
            'campo2' => 'valor2',
        ];

        $this->dbConnectionMock->expects($this->once())
            ->method('inserir')
            ->with(
                $this->equalTo("tabela_teste"),
                $this->equalTo($dadosInsercao)
            )
            ->willReturn(true);

        $insercaoBemSucedida = $this->dbConnectionMock->inserir('tabela_teste', $dadosInsercao);
        $this->assertTrue($insercaoBemSucedida);
    }
    public function testInserirComErro()
    {
        $dadosInsercao = [
            'campo1' => 'valor1',
            'campo2' => 'valor2',
        ];

        $this->dbConnectionMock->expects($this->once())
            ->method('inserir')
            ->with(
                $this->equalTo("tabela_teste"),
                $this->equalTo($dadosInsercao)
            )
            ->willReturn(false);

        $resultado = $this->dbConnectionMock->inserir('tabela_teste', $dadosInsercao);
        $this->assertFalse($resultado);
    }

    public function testExcluirComSucesso()
    {

        $this->dbConnectionMock = $this->createMock(MySqlConnection::class);

        $id = 1;

        $this->dbConnectionMock->expects($this->once())
            ->method('excluir')
            ->with(
                $this->equalTo("tabela_teste"),
                $this->equalTo($id)
            )
            ->willReturn(true);


        $resultado = $this->dbConnectionMock->excluir('tabela_teste', $id);
        $this->assertTrue($resultado);
    }
    public function testExcluirComErro()
    {

        $this->dbConnectionMock = $this->createMock(MySqlConnection::class);

        $id = 1;

        $this->dbConnectionMock->expects($this->once())
            ->method('excluir')
            ->with(
                $this->equalTo("tabela_teste"),
                $this->equalTo($id)
            )
            ->willReturn(false);


        $resultado = $this->dbConnectionMock->excluir('tabela_teste', $id);
        $this->assertFalse($resultado);
    }

    public function testAtualizarComSucesso()
    {
        $this->dbConnectionMock = $this->createMock(MySqlConnection::class);
        $id = 1;

        $dadosAtualizacao = [
            'campo1' => 'novo_valor1',
            'campo2' => 'novo_valor2',
        ];

        $this->dbConnectionMock->expects($this->once())
            ->method('atualizar')
            ->with(
                $this->equalTo("tabela_teste"),
                $this->equalTo($id),
                $this->equalTo($dadosAtualizacao)
            )
            ->willReturn(true);

        $resultado = $this->dbConnectionMock->atualizar('tabela_teste', $id, $dadosAtualizacao);
        $this->assertTrue($resultado);
    }

    public function testAtualizarComErro()
    {
        $this->dbConnectionMock = $this->createMock(MySqlConnection::class);
        $id = 1;

        $dadosAtualizacao = [
            'campo1' => 'novo_valor1',
            'campo2' => 'novo_valor2',
        ];

        $this->dbConnectionMock->expects($this->once())
            ->method('atualizar')
            ->with(
                $this->equalTo("tabela_teste"),
                $this->equalTo($id),
                $this->equalTo($dadosAtualizacao)
            )
            ->willReturn(false);

        $resultado = $this->dbConnectionMock->atualizar('tabela_teste', $id, $dadosAtualizacao);
        $this->assertFalse($resultado);
    }

    public function testBuscarPorParametros()
    {
        $this->dbConnectionMock = $this->createMock(MySqlConnection::class);

        $campos = ['campo1', 'campo2'];
        $parametros = [
            ['campo' => 'campo1', 'valor' => 'valor1'],
            ['campo' => 'campo2', 'valor' => 'valor2'],
        ];

        $this->dbConnectionMock->expects($this->once())
            ->method('buscarPorParametros')
            ->with(
                $this->equalTo("tabela_teste"),
                $this->equalTo($campos),
                $this->equalTo($parametros)
            )
            ->willReturn($parametros);

        $resultadoBusca = $this->dbConnectionMock->buscarPorParametros('tabela_teste', $campos, $parametros);
        $this->assertEquals($parametros, $resultadoBusca);
    }

    public function testBuscarTodosPedidos()
    {
        $this->dbConnectionMock = $this->createMock(MySqlConnection::class);
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
            },
            {
                "idPedido": 3,
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
            },
            {
                "idPedido": 4,
                "dataCriacao": "2023-09-23 11:27:02",
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
        $this->dbConnectionMock->expects($this->once())
            ->method('buscarTodosPedidos')
            ->with("pedidos")
            ->willReturn($arrayEsperado);
        $resultadoBusca = $this->dbConnectionMock->buscarTodosPedidos('pedidos');
        $this->assertEquals($arrayEsperado, $resultadoBusca);
    }
}
