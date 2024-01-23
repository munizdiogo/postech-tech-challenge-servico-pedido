<?php

use PHPUnit\Framework\TestCase;
use Entities\Cliente;

class ClienteTest extends TestCase
{
    public function testGetNome()
    {
        $nome = 'João Silva';
        $email = 'joao@example.com';
        $cpf = '123.456.789-00';

        $cliente = new Cliente($nome, $email, $cpf);

        $this->assertEquals($nome, $cliente->getNome());
    }

    public function testGetEmail()
    {
        $nome = 'Maria Santos';
        $email = 'maria@example.com';
        $cpf = '987.654.321-00';

        $cliente = new Cliente($nome, $email, $cpf);

        $this->assertEquals($email, $cliente->getEmail());
    }

    public function testgetCPF()
    {
        $nome = 'José Pereira';
        $email = 'jose@example.com';
        $cpf = '111.222.333-44';

        $cliente = new Cliente($nome, $email, $cpf);

        $this->assertEquals($cpf, $cliente->getCPF());
    }
}
