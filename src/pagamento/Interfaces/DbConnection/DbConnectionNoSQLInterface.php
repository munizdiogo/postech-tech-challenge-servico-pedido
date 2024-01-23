<?php

namespace Pagamento\Interfaces\DbConnection;

interface DbConnectionNoSQLInterface
{
    public function conectar();
    public function inserir(string $nomeTabela, array $parametros);
}
