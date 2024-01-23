<?php

namespace Produto\Interfaces\Entities;

interface ProdutoInterface
{
    public function getId(): string;
    public function setId($id);
    public function getNome(): string;
    public function getDescricao(): string;
    public function getPreco(): string;
    public function getCategoria(): string;
}
