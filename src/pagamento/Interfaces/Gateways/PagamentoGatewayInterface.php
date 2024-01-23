<?php

namespace Pagamento\Interfaces\Gateways;

use Pagamento\Entities\Pedido;

interface PagamentoGatewayInterface
{
    public function cadastrar(Pedido $pedido);
}
