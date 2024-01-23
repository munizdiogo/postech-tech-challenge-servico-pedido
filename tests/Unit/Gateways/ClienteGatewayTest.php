<?php

use External\MySqlConnection;
use PHPUnit\Framework\TestCase;
use Gateways\ClienteGateway;
use Entities\Cliente;

class ClienteGatewayTest extends TestCase
{

    protected $dbConnectionMock;
    protected $clienteGatewayMock;

    public function setUp(): void
    {
        parent::setUp();
        $this->dbConnectionMock = $this->createMock(MySqlConnection::class);
        $this->clienteGatewayMock = $this->getMockBuilder(ClienteGateway::class)
            ->setConstructorArgs([$this->dbConnectionMock])
            ->getMock();
    }

    public function testCadastrarClienteComSucesso()
    {
        $cliente = new Cliente('João', 'joao@example.com', '12345678909');
        $this->clienteGatewayMock->expects($this->once())
            ->method('cadastrar')
            ->with($cliente)
            ->willReturn(true);

        $resultado = $this->clienteGatewayMock->cadastrar($cliente);
        $this->assertTrue($resultado);
    }

    public function testCadastrarClienteComErro()
    {
        $cliente = new Cliente('João', 'joao@example.com', '12345678909');
        $this->clienteGatewayMock->expects($this->once())
            ->method('cadastrar')
            ->with($cliente)
            ->willReturn(false);

        $resultado = $this->clienteGatewayMock->cadastrar($cliente);
        $this->assertFalse($resultado);
    }

    public function testObterClientePorCpfEncontrado()
    {
        $cpf = '12345678909';

        $clienteEsperado = [
            'nome' => 'Maria',
            'email' => 'maria@example.com',
            'cpf' => $cpf,
        ];

        $this->clienteGatewayMock->expects($this->once())
            ->method('obterClientePorCPF')
            ->with($cpf)
            ->willReturn($clienteEsperado);


        $resultado = $this->clienteGatewayMock->obterClientePorCPF($cpf);
        $this->assertEquals($clienteEsperado, $resultado);
    }

    public function testObterClientePorCPFNaoEncontrado()
    {

        $cpf = '9999999999';

        $this->clienteGatewayMock->expects($this->once())
            ->method('obterClientePorCPF')
            ->with($cpf)
            ->willReturn([]);


        $resultado = $this->clienteGatewayMock->obterClientePorCPF($cpf);
        $this->assertEquals([], $resultado);
    }
}
