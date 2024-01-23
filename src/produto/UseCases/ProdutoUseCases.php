<?php

namespace ProdutoUseCases\UseCases;

require "./src/produto/Interfaces/UseCases/ProdutoUseCasesInterface.php";

use Produto\Entities\Produto;
use Produto\Gateways\ProdutoGateway;
use Produto\Interfaces\UseCases\ProdutoUseCasesInterface;

class ProdutoUseCases implements ProdutoUseCasesInterface
{
    public function cadastrar(ProdutoGateway $produtoGateway, Produto $produto)
    {
        if (empty($produto->getNome())) {
            retornarRespostaJSON("O campo nome é obrigatório.", 400);
            die();
        }

        if (empty($produto->getDescricao())) {
            retornarRespostaJSON("O campo descricao é obrigatório.", 400);
            die();
        }

        if (empty($produto->getPreco())) {
            retornarRespostaJSON("O campo preco é obrigatório.", 400);
            die();
        }

        if (empty($produto->getCategoria())) {
            retornarRespostaJSON("O campo categoria é obrigatório.", 400);
            die();
        }

        $produtoJaCadastrado = $produtoGateway->obterPorNome($produto->getNome());

        if (!empty($produtoJaCadastrado)) {
            retornarRespostaJSON("Já existe um produto cadastrado com esse nome.", 409);
            die();
        }

        $resultadoCadastro = $produtoGateway->cadastrar($produto);
        return $resultadoCadastro;
    }

    public function atualizar(ProdutoGateway $produtoGateway, int $id, Produto $produto)
    {
        if (empty($id)) {
            retornarRespostaJSON("O campo id é obrigatório.", 400);
            die();
        }

        if (empty($produto->getNome())) {
            retornarRespostaJSON("O campo nome é obrigatório.", 400);
            die();
        }

        if (empty($produto->getDescricao())) {
            retornarRespostaJSON("O campo descricao é obrigatório.", 400);
            die();
        }

        if (empty($produto->getPreco())) {
            retornarRespostaJSON("O campo preco é obrigatório.", 400);
            die();
        }

        if (empty($produto->getCategoria())) {
            retornarRespostaJSON("O campo categoria é obrigatório.", 400);
            die();
        }

        $produtoEncontrado = $produtoGateway->obterPorId($id);

        if ($produtoEncontrado) {
            $produtoAtualizado = new Produto(
                $produto->getNome() ?? $produtoEncontrado["nome"],
                $produto->getDescricao() ?? $produtoEncontrado["descricao"],
                $produto->getPreco() ?? $produtoEncontrado["preco"],
                $produto->getCategoria() ?? $produtoEncontrado["categoria"]
            );
            $resultadoAtualizacao = $produtoGateway->atualizar($id, $produtoAtualizado);
            return $resultadoAtualizacao;
        } else {
            retornarRespostaJSON("Não foi encontrado um produto com o ID informado.", 400);
            die();
        }
    }

    public function excluir(ProdutoGateway $produtoGateway, int $id)
    {
        if (empty($id)) {
            retornarRespostaJSON("O campo ID é obrigatório.", 400);
            die();
        }

        $produtoEncontrado = $produtoGateway->obterPorId($id);

        if ($produtoEncontrado) {
            $resultadoAtualizacao = $produtoGateway->excluir($id);
            return $resultadoAtualizacao;
        } else {
            retornarRespostaJSON("Não foi encontrado um produto com o ID informado.", 400);
            die();
        }
    }

    public function obterPorCategoria(ProdutoGateway $produtoGateway, string $categoria)
    {
        if (empty($categoria)) {
            retornarRespostaJSON("O campo categoria é obrigatório.", 400);
            die();
        }

        $produtos = $produtoGateway->obterPorCategoria($categoria);
        return $produtos;
    }
}
