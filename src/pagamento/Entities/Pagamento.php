<?php

namespace Pagamento\Entities;

use Pagamento\Interfaces\Entities\PagamentoInterface;

class Pagamento implements PagamentoInterface
{

    private string $id;
    private string $status;
    private string $cpf;
    private array $produtos;

    public function __construct(string $status, string $cpf, array $produtos = [])
    {
        $this->status = $status;
        $this->cpf = $cpf;
        $this->produtos = $produtos;
    }


    public function getId(): string
    {
        return $this->id;
    }


    public function getStatus(): string
    {
        return $this->status;
    }


    public function getCPF(): string
    {
        return $this->cpf;
    }



    public function getProdutos(): array
    {
        return $this->produtos;
    }
}
