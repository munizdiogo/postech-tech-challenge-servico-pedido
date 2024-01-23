<?php

namespace Autenticacao\Controllers;

require "./src/autenticacao/Interfaces/AutenticacaoControllerInterface.php";

use Exception;
use Firebase\JWT\JWT;
use Autenticacao\Interfaces\AutenticacaoControllerInterface;

class AutenticacaoController implements AutenticacaoControllerInterface
{
    function pegarHeaders()
    {
        $headers = array();
        foreach ($_SERVER as $key => $value) {
            if (substr($key, 0, 5) <> 'HTTP_') {
                continue;
            }
            $header = str_replace(' ', '-', ucwords(str_replace('_', ' ', strtolower(substr($key, 5)))));
            $headers[$key] = $value;
        }
        return $headers;
    }


    function gerarToken($cpf = '')
    {
        try {
            if (!empty($cpf)) {

                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://fqxe3wyeeg.execute-api.us-east-1.amazonaws.com/login',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => '{
                  "cpf": "55555555555"
                }',
                    CURLOPT_HTTPHEADER => array(
                        'Content-Type: application/json'
                    ),
                ));

                $response = curl_exec($curl);

                curl_close($curl);
                http_response_code(200);
                return $response;
            }
        } catch (Exception $e) {
            http_response_code(401);
            return false;
        }
    }


    function criarContaCognito($cpf = '', $nome = '', $email = '')
    {

        try {
            if (!empty($cpf)) {
                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://fqxe3wyeeg.execute-api.us-east-1.amazonaws.com/criar-usuario',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => '{
                        "email": "' . $email . '",
                        "name": "' . $nome . '",
                        "cpf": "' . $cpf . '"
                    }',
                    CURLOPT_HTTPHEADER => array(
                        'Content-Type: application/json'
                    ),
                ));

                $response = curl_exec($curl);

                curl_close($curl);
                http_response_code(200);
                return $response;
            }
        } catch (Exception $e) {
            http_response_code(401);
            return false;
        }
    }
}
