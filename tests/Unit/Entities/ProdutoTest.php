<?php

use PHPUnit\Framework\TestCase;
use Entities\Produto;

class ProdutoTest extends TestCase
{
    public function testGetId()
    {
        $produto = new Produto('Produto A', 'Descrição A', '10.99', 'Categoria A');

        // Defina um ID personalizado
        $produto->setId('12345');

        $this->assertSame('12345', $produto->getId());
    }

    public function testSetId()
    {
        $produto = new Produto('Produto A', 'Descrição A', '10.99', 'Categoria A');

        // Defina um ID personalizado
        $produto->setId('12345');

        // Verifique se o ID foi definido corretamente
        $this->assertSame('12345', $produto->getId());
    }

    public function testGetNome()
    {
        $produto = new Produto('Produto A', 'Descrição A', '10.99', 'Categoria A');

        // Verifique se o nome do produto é o esperado
        $this->assertSame('Produto A', $produto->getNome());
    }

    public function testGetDescricao()
    {
        $produto = new Produto('Produto A', 'Descrição A', '10.99', 'Categoria A');

        // Verifique se a descrição do produto é a esperada
        $this->assertSame('Descrição A', $produto->getDescricao());
    }

    public function testGetPreco()
    {
        $produto = new Produto('Produto A', 'Descrição A', '10.99', 'Categoria A');

        // Verifique se o preço do produto é o esperado
        $this->assertSame('10.99', $produto->getPreco());
    }

    public function testGetCategoria()
    {
        $produto = new Produto('Produto A', 'Descrição A', '10.99', 'Categoria A');

        // Verifique se a categoria do produto é a esperada
        $this->assertSame('Categoria A', $produto->getCategoria());
    }
}
