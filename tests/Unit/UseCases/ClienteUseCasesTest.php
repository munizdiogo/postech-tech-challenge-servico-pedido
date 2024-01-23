<?php

use External\MySqlConnection;
use PHPUnit\Framework\TestCase;
use UseCases\ClienteUseCases;
use Entities\Cliente;
use Gateways\ClienteGateway;

class ClienteUseCasesTest extends TestCase
{

    protected $dbConnectionMock;
    protected $clienteGatewayMock;
    protected $clienteUseCasesMock;
    public function setUp(): void
    {
        parent::setUp();
        $this->dbConnectionMock = $this->createMock(MySqlConnection::class);

        $this->clienteGatewayMock = $this->getMockBuilder(ClienteGateway::class)
            ->setConstructorArgs([$this->dbConnectionMock])
            ->getMock();

        $this->clienteUseCasesMock = $this->createMock(ClienteUseCases::class);
    }

    public function testCadastrarClienteComSucesso()
    {
        $cliente = new Cliente("Rodrigo", "teste@teste.com", "12345678923");
        $this->clienteUseCasesMock->expects($this->once())
            ->method('cadastrar')
            ->with(
                $this->equalTo($this->clienteGatewayMock),
                $this->equalTo($cliente)
            )
            ->willReturn(true);

        $resultado = $this->clienteUseCasesMock->cadastrar($this->clienteGatewayMock, $cliente);
        $this->assertTrue($resultado);
    }
    public function testCadastrarClienteComErro()
    {
        $cliente = new Cliente("Rodrigo", "teste@teste.com", "12345678923");
        $this->clienteUseCasesMock->expects($this->once())
            ->method('cadastrar')
            ->with(
                $this->equalTo($this->clienteGatewayMock),
                $this->equalTo($cliente)
            )
            ->willReturn(false);

        $resultado = $this->clienteUseCasesMock->cadastrar($this->clienteGatewayMock, $cliente);
        $this->assertFalse($resultado);
    }

    public function testCadastrarClienteJaExistente()
    {

        $cliente = new Cliente("Rodrigo", "teste@teste.com", "12345678923");

        $this->clienteUseCasesMock->expects($this->once())
            ->method('cadastrar')
            ->with(
                $this->equalTo($this->clienteGatewayMock),
                $this->equalTo($cliente)
            )
            ->willReturn('{"mensagem": "Já existe um cliente cadastrado com este CPF."}');

        $resultado = $this->clienteUseCasesMock->cadastrar($this->clienteGatewayMock, $cliente);
        $resultadoArray = json_decode($resultado, true);
        $this->assertEquals($resultadoArray["mensagem"], "Já existe um cliente cadastrado com este CPF.");
    }

    public function testCadastrarClienteComCamposFaltando()
    {
        $cliente = new Cliente("Rodrigo", "teste@teste.com", "");
        $this->clienteUseCasesMock->expects($this->once())
            ->method('cadastrar')
            ->with(
                $this->equalTo($this->clienteGatewayMock),
                $this->equalTo($cliente)
            )
            ->willReturn('{"mensagem": "O campo cpf é obrigatório."}');

        $resultado = $this->clienteUseCasesMock->cadastrar($this->clienteGatewayMock, $cliente);
        $resultadoArray = json_decode($resultado, true);
        $this->assertEquals($resultadoArray["mensagem"], "O campo cpf é obrigatório.");
    }
}
