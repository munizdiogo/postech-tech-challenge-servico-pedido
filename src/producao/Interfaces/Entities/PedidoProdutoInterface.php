<?php

namespace Interfaces\Entities;

interface PedidoProdutoInterface
{
    public function getIdPedido(): string;
    public function getIdProduto(): string;
    public function getNomeProduto(): string;
    public function getDescricaoProduto(): string;
    public function getPrecoProduto(): string;
    public function getCategoriaProduto(): string;
    public function getDataCriacao(): string;
}
