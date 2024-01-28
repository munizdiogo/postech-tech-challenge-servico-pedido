<?php

namespace Pedido\Interfaces\Entities;

interface PedidoInterface
{
    public function getStatus(): string;
    public function getCPF(): string;
    public function getProdutos(): array;
}
