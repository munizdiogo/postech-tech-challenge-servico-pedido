<?php

use PHPUnit\Framework\TestCase;
use Pedido\Entities\Pedido;

class PedidoTest extends TestCase
{
    public function testGetStatus()
    {
        $status = 'recebido';
        $cpf = '1';
        $produtos = ['Produto A', 'Produto B'];

        $pedido = new Pedido($status, $cpf, $produtos);

        $this->assertEquals($status, $pedido->getStatus());
    }

    public function testgetCPF()
    {
        $status = 'finalizado';
        $cpf = '2';
        $produtos = ['Produto C', 'Produto D'];

        $pedido = new Pedido($status, $cpf, $produtos);

        $this->assertEquals($cpf, $pedido->getCPF());
    }

    public function testGetProdutos()
    {
        $status = 'em_preparacao';
        $cpf = '3';
        $produtos = ['Produto E', 'Produto F'];

        $pedido = new Pedido($status, $cpf, $produtos);

        $this->assertEquals($produtos, $pedido->getProdutos());
    }
}
