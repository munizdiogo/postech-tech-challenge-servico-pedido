<?php


namespace Produto\Interfaces\Controllers;

interface ProdutoControllerInterface
{
    public function cadastrar($dbConnection, array $dados);
    public function atualizar($dbConnection, array $dados);
    public function excluir($dbConnection, int $id);
    public function obterPorCategoria($dbConnection, string $nome);
}
