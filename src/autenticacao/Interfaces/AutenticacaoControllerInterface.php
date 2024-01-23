<?php

namespace Autenticacao\Interfaces;

interface AutenticacaoControllerInterface
{
    public function pegarHeaders();
    public function gerarToken($tcpfoken = '');
    public function criarContaCognito($cpf = '', $nome = '', $email = '');
}
