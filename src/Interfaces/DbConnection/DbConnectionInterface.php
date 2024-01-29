<?php

namespace Pedido\Interfaces\DbConnection;

interface DbConnectionInterface
{
    public function conectar();
    public function inserir(string $nomeTabela, array $parametros);
    public function buscarTodosPedidosPorCpf(string $nomeTabela, string $cpf): array;
    public function buscarPorParametros(string $nomeTabela, array $campos, array $parametros): array;
    public function excluir(string $nomeTabela, int $id): bool;
    public function excluirProdutos(string $nomeTabela, int $id): bool;
    public function buscarTodosPedidos(string $nomeTabela): array;
}
