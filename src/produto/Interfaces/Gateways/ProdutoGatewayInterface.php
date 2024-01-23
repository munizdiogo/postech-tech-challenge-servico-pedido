<?php

namespace Produto\Interfaces\Gateways;

use Produto\Entities\Produto;

interface ProdutoGatewayInterface
{
    public function cadastrar(Produto $produto): bool;
    public function atualizar(int $id, Produto $produto): bool;
    public function excluir(int $id): bool;
    public function obterPorCategoria(string $categoria): array;
    public function obterPorNome(string $nome): array;
    public function obterPorId(string $id): array;
}
