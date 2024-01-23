<?php

namespace Controllers;

use Controllers\PedidoController;
use External\MySqlConnection;
use PHPUnit\Framework\TestCase;

class PedidoControllerTest extends TestCase
{
    protected $pedidoController;
    protected $dbConnectionMock;
    protected $pedidoControllerMock;

    public function setUp(): void
    {
        parent::setUp();
        $this->pedidoController = new PedidoController();
        $this->dbConnectionMock = $this->createMock(MySqlConnection::class);
        $this->pedidoControllerMock = $this->createMock(PedidoController::class);
    }

    public function testCadastrarPedidoComSucesso()
    {
        $json = '{
            "cpf": 1,
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

        $this->pedidoControllerMock->expects($this->once())
            ->method('cadastrar')
            ->with(
                $this->equalTo($this->dbConnectionMock),
                $this->equalTo($dadosValidos)
            )
            ->willReturn(123);

        $resultado = $this->pedidoControllerMock->cadastrar($this->dbConnectionMock, $dadosValidos);
        $this->assertIsInt($resultado);
    }
    public function testCadastrarPedidoComErro()
    {
        $json = '{
            "cpf": 1,
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

        $this->pedidoControllerMock->expects($this->once())
            ->method('cadastrar')
            ->with(
                $this->equalTo($this->dbConnectionMock),
                $this->equalTo($dadosValidos)
            )
            ->willReturn(false);
        
        $resultado = $this->pedidoControllerMock->cadastrar($this->dbConnectionMock, $dadosValidos);
        $this->assertFalse($resultado);
    }

    public function testCadastrarPedidoComCamposFaltando()
    {
        
        $dadosFaltando = [
            'cpf' => 1
        ];
        
        $this->pedidoControllerMock->expects($this->once())
            ->method('cadastrar')
            ->with(
                $this->equalTo($this->dbConnectionMock),
                $this->equalTo($dadosFaltando)
            )
            ->willReturn('{"mensagem":"O campo \'produtos\' é obrigatório."}');
        
        $resultado = $this->pedidoControllerMock->cadastrar($this->dbConnectionMock, $dadosFaltando);
        $resultadoArray = json_decode($resultado, true);
        $this->assertEquals(['mensagem' => "O campo 'produtos' é obrigatório."], $resultadoArray);
    }

    public function testObterPedidosComPedidosExistentes()
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

        $array = json_decode($json, true);

        $this->pedidoControllerMock->expects($this->once())
            ->method('obterPedidos')
            ->with(
                $this->equalTo($this->dbConnectionMock)
            )
            ->willReturn($array);

        $resultado = $this->pedidoControllerMock->obterPedidos($this->dbConnectionMock);
        $this->assertEquals($array, $resultado);
    }

    public function testObterPedidosSemPedidosExistentes()
    {
        $this->pedidoControllerMock->expects($this->once())
            ->method('obterPedidos')
            ->with(
                $this->equalTo($this->dbConnectionMock)
            )
            ->willReturn([]);

        $resultado = $this->pedidoControllerMock->obterPedidos($this->dbConnectionMock);
        $this->assertEquals([], $resultado);
    }
}
