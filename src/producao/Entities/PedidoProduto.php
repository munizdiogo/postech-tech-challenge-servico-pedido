<?php

namespace Entities;

use Interfaces\Entities\PedidoProdutoInterface;

class PedidoProduto implements PedidoProdutoInterface
{

    private string $idPedido;
    private string $idProduto;
    private string $nomeProduto;
    private string $descricaoProduto;
    private string $precoProduto;
    private string $categoriaProduto;
    private string $dataCriacao;

    public function __construct($idPedido, $idProduto, $nomeProduto, $descricaoProduto, $precoProduto, $categoriaProduto, $dataCriacao)
    {
        $this->idPedido = $idPedido;
        $this->idProduto = $idProduto;
        $this->nomeProduto = $nomeProduto;
        $this->descricaoProduto = $descricaoProduto;
        $this->precoProduto = $precoProduto;
        $this->categoriaProduto = $categoriaProduto;
        $this->dataCriacao = $dataCriacao;
    }


    public function getIdPedido(): string
    {
        return $this->idPedido;
    }


    public function getIdProduto(): string
    {
        return $this->idProduto;
    }


    public function getNomeProduto(): string
    {
        return $this->nomeProduto;
    }


    public function getDescricaoProduto(): string
    {
        return $this->descricaoProduto;
    }


    public function getPrecoProduto(): string
    {
        return $this->precoProduto;
    }


    public function getCategoriaProduto(): string
    {
        return $this->categoriaProduto;
    }


    public function getDataCriacao(): string
    {
        return $this->dataCriacao;
    }
}
