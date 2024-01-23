<?php

namespace Controllers;

use Controllers\ClienteController;
use External\MySqlConnection;
use PHPUnit\Framework\TestCase;

class ClienteControllerTest extends TestCase
{
    protected $dbConnectionMock;
    protected $clienteControllerMock;

    public function setUp(): void
    {
        parent::setUp();
        $this->dbConnectionMock = $this->createMock(MySqlConnection::class);
        $this->clienteControllerMock = $this->createMock(ClienteController::class);
    }

    public function testCadastrarClienteComSucesso()
    {
        $dadosValidos = [
            'nome' => 'João 1',
            'email' => 'joao@example.com',
            'cpf' => '12345678900'
        ];

        $this->clienteControllerMock->expects($this->once())
            ->method('cadastrar')
            ->with(
                $this->equalTo($this->dbConnectionMock),
                $this->equalTo($dadosValidos)
            )
            ->willReturn(true);

        $resultado = $this->clienteControllerMock->cadastrar($this->dbConnectionMock, $dadosValidos);
        $this->assertTrue($resultado);
    }
    public function testCadastrarClienteComErro()
    {
        $dadosValidos = [
            'nome' => 'João 1',
            'email' => 'joao@example.com',
            'cpf' => '12345678900'
        ];

        $this->clienteControllerMock->expects($this->once())
            ->method('cadastrar')
            ->with(
                $this->equalTo($this->dbConnectionMock),
                $this->equalTo($dadosValidos)
            )
            ->willReturn(false);

        $resultado = $this->clienteControllerMock->cadastrar($this->dbConnectionMock, $dadosValidos);
        $this->assertFalse($resultado);
    }
    public function testCadastrarClienteJaExistente()
    {
        $dadosValidos = [
            'nome' => 'João 1',
            'email' => 'joao@example.com',
            'cpf' => '12345678900'
        ];

        $this->clienteControllerMock->expects($this->once())
            ->method('cadastrar')
            ->with(
                $this->equalTo($this->dbConnectionMock),
                $this->equalTo($dadosValidos)
            )
            ->willReturn('{"mensagem":"Já existe um cliente cadastrado com este CPF."}');

        $resultado = $this->clienteControllerMock->cadastrar($this->dbConnectionMock, $dadosValidos);
        $resultadoArray = json_decode($resultado, true);
        $this->assertEquals(['mensagem' => "Já existe um cliente cadastrado com este CPF."], $resultadoArray);
    }
    public function testCadastrarClienteComCamposFaltando()
    {
        $dadosValidos = [
            'nome' => 'João 1',
            'cpf' => '12345678900'
        ];

        $this->clienteControllerMock->expects($this->once())
            ->method('cadastrar')
            ->with(
                $this->equalTo($this->dbConnectionMock),
                $this->equalTo($dadosValidos)
            )
            ->willReturn('{"mensagem":"O campo \'email\' é obrigatório."}');

        $resultado = $this->clienteControllerMock->cadastrar($this->dbConnectionMock, $dadosValidos);
        $resultadoArray = json_decode($resultado, true);
        $this->assertEquals(['mensagem' => "O campo 'email' é obrigatório."], $resultadoArray);
    }



    public function testBuscarClientePorCpfEncontrado()
    {
        $cpfValido = '12345678900';

        $json = '{
            "id": "1",
            "data_criacao": "2023-09-23 10:45:54",
            "data_alteracao": null,
            "nome": "José Da Silva",
            "email": "jose@teste.com.br",
            "cpf": "12345678909"
        }';

        $array = json_decode($json, true);

        $this->clienteControllerMock->expects($this->once())
            ->method('buscarPorCPF')
            ->with(
                $this->equalTo($this->dbConnectionMock),
                $this->equalTo($cpfValido)
            )
            ->willReturn($array);

        $resultado = $this->clienteControllerMock->buscarPorCPF($this->dbConnectionMock, $cpfValido);
        $this->assertEquals($array, $resultado);
    }

    public function testBuscarClientePorCpfNaoEncontrado()
    {
        $cpfValido = '12345678900';

        $this->clienteControllerMock->expects($this->once())
            ->method('buscarPorCPF')
            ->with(
                $this->equalTo($this->dbConnectionMock),
                $this->equalTo($cpfValido)
            )
            ->willReturn([]);

        $resultado = $this->clienteControllerMock->buscarPorCPF($this->dbConnectionMock, $cpfValido);
        $this->assertEquals([], $resultado);
    }

    public function testBuscarClientePorCPFComCPFVazio()
    {
        $cpfVazio = '';

        $this->clienteControllerMock->expects($this->once())
            ->method('buscarPorCPF')
            ->with(
                $this->equalTo($this->dbConnectionMock),
                $this->equalTo($cpfVazio)
            )
            ->willReturn('{"mensagem":"O campo CPF é obrigatório."}');

        $resultado = $this->clienteControllerMock->buscarPorCPF($this->dbConnectionMock, $cpfVazio);
        $resultadoArray = json_decode($resultado, true);
        $this->assertEquals(['mensagem' => "O campo CPF é obrigatório."], $resultadoArray);
    }
}
