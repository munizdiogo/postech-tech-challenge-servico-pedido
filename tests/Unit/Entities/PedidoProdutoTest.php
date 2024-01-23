<?php

use PHPUnit\Framework\TestCase;
use Entities\PedidoProduto;

class PedidoProdutoTest extends TestCase
{
    public function testGetIdPedido()
    {
        $idPedido = '1';
        $idProduto = '101';
        $nomeProduto = 'Produto A';
        $descricaoProduto = 'Descrição do Produto A';
        $precoProduto = '10.99';
        $categoriaProduto = 'Categoria A';
        $dataCriacao = '2023-09-01 12:00:00';

        $pedidoProduto = new PedidoProduto($idPedido, $idProduto, $nomeProduto, $descricaoProduto, $precoProduto, $categoriaProduto, $dataCriacao);

        $this->assertEquals($idPedido, $pedidoProduto->getIdPedido());
    }

    public function testGetIdProduto()
    {
        $idPedido = '1';
        $idProduto = '101';
        $nomeProduto = 'Produto A';
        $descricaoProduto = 'Descrição do Produto A';
        $precoProduto = '10.99';
        $categoriaProduto = 'Categoria A';
        $dataCriacao = '2023-09-01 12:00:00';

        $pedidoProduto = new PedidoProduto($idPedido, $idProduto, $nomeProduto, $descricaoProduto, $precoProduto, $categoriaProduto, $dataCriacao);

        $this->assertEquals($idProduto, $pedidoProduto->getIdProduto());
    }

    public function testGetNomeProduto()
    {
        $idPedido = '1';
        $idProduto = '101';
        $nomeProduto = 'Produto A';
        $descricaoProduto = 'Descrição do Produto A';
        $precoProduto = '10.99';
        $categoriaProduto = 'Categoria A';
        $dataCriacao = '2023-09-01 12:00:00';

        $pedidoProduto = new PedidoProduto($idPedido, $idProduto, $nomeProduto, $descricaoProduto, $precoProduto, $categoriaProduto, $dataCriacao);

        $this->assertEquals($nomeProduto, $pedidoProduto->getNomeProduto());
    }

    public function testGetDescricaoProduto()
    {
        $idPedido = '1';
        $idProduto = '101';
        $nomeProduto = 'Produto A';
        $descricaoProduto = 'Descrição do Produto A';
        $precoProduto = '10.99';
        $categoriaProduto = 'Categoria A';
        $dataCriacao = '2023-09-01 12:00:00';

        $pedidoProduto = new PedidoProduto($idPedido, $idProduto, $nomeProduto, $descricaoProduto, $precoProduto, $categoriaProduto, $dataCriacao);

        $this->assertEquals($descricaoProduto, $pedidoProduto->getDescricaoProduto());
    }

    public function testGetPrecoProduto()
    {
        $idPedido = '1';
        $idProduto = '101';
        $nomeProduto = 'Produto A';
        $descricaoProduto = 'Descrição do Produto A';
        $precoProduto = '10.99';
        $categoriaProduto = 'Categoria A';
        $dataCriacao = '2023-09-01 12:00:00';

        $pedidoProduto = new PedidoProduto($idPedido, $idProduto, $nomeProduto, $descricaoProduto, $precoProduto, $categoriaProduto, $dataCriacao);

        $this->assertEquals($precoProduto, $pedidoProduto->getPrecoProduto());
    }

    public function testGetCategoriaProduto()
    {
        $idPedido = '1';
        $idProduto = '101';
        $nomeProduto = 'Produto A';
        $descricaoProduto = 'Descrição do Produto A';
        $precoProduto = '10.99';
        $categoriaProduto = 'Categoria A';
        $dataCriacao = '2023-09-01 12:00:00';

        $pedidoProduto = new PedidoProduto($idPedido, $idProduto, $nomeProduto, $descricaoProduto, $precoProduto, $categoriaProduto, $dataCriacao);

        $this->assertEquals($categoriaProduto, $pedidoProduto->getCategoriaProduto());
    }

    public function testGetDataCriacao()
    {
        $idPedido = '1';
        $idProduto = '101';
        $nomeProduto = 'Produto A';
        $descricaoProduto = 'Descrição do Produto A';
        $precoProduto = '10.99';
        $categoriaProduto = 'Categoria A';
        $dataCriacao = '2023-09-01 12:00:00';

        $pedidoProduto = new PedidoProduto($idPedido, $idProduto, $nomeProduto, $descricaoProduto, $precoProduto, $categoriaProduto, $dataCriacao);

        $this->assertEquals($dataCriacao, $pedidoProduto->getDataCriacao());
    }
}
