<?php

namespace Produto\Entities;

require "./src/produto/Interfaces/Entities/ProdutoInterface.php";

use Produto\Interfaces\Entities\ProdutoInterface;

class Produto implements ProdutoInterface
{
    private string $id;
    private string $nome;
    private string $descricao;
    private string $preco;
    private string $categoria;

    public function __construct($nome, $descricao, $preco, $categoria)
    {
        $this->nome = $nome;
        $this->descricao = $descricao;
        $this->preco = $preco;
        $this->categoria = $categoria;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getNome(): string
    {
        return $this->nome;
    }


    public function getDescricao(): string
    {
        return $this->descricao;
    }


    public function getPreco(): string
    {
        return $this->preco;
    }


    public function getCategoria(): string
    {
        return $this->categoria;
    }
}
