<?php

require "./src/External/MySqlConnection.php";
require "./src/Controllers/PedidoController.php";

use Pedido\External\MySqlConnection;
use PHPUnit\Framework\TestCase;
use Behat\Behat\Context\Context;
use Pedido\Controllers\PedidoController;

class FeatureContext extends TestCase implements Context
{
    private $resultado;
    private $pedidoController;
    private $exceptionMessage;
    private $exceptionCode;
    private $dadosPedido;
    private $idPedido;
    private $pedidos;
    private $producaoMySqlConnection;
    private $novoStatusPedido;
    private $dbConnection;

    public function __construct()
    {
        $this->dbConnection = new MySqlConnection();
        $this->pedidoController = new PedidoController();
    }

    /**
     * @Given que existem dados válidos para cadastro
     */
    public function queExistemDadosValidosParaCadastro()
    {
        $this->dadosPedido = '{
            "cpf": "42157363823",
            "produtos": [
                {
                    "id": 2,
                    "nome": "Produto 1",
                    "descricao": "Descrição do Produto 1",
                    "preco": 20.99,
                    "categoria": "lanche"
                },
                 {
                    "id": 3,
                    "nome": "Produto 2",
                    "descricao": "Descrição do Produto 2",
                    "preco": 15.99,
                    "categoria": "bebida"
                }
            ]
        }';
    }

    /**
     * @When eu chamar a função de cadastrar pedido
     */
    public function euChamarAFuncaoDeCadastrarPedido()
    {
        $dadosValidos = json_decode($this->dadosPedido, true);
        $this->idPedido = $this->pedidoController->cadastrar($this->dbConnection, $dadosValidos);
    }

    /**
     * @Then eu devo receber o ID do pedido cadastrado
     */
    public function euDevoReceberOIdDoPedidoCadastrado()
    {
        $this->assertIsInt($this->idPedido);
        $pedidos = $this->pedidoController->buscarPedidosPorCpf($this->dbConnection, "42157363823");
        $pedidoExcluido = $this->pedidoController->excluir($this->dbConnection,  $pedidos[0]["idPedido"]);
        $this->assertTrue($pedidoExcluido);
    }

    /**
     * @Given que não há CPF fornecido para o cadastro do pedido
     */
    public function queNaoHaCpfFornecidoParaOCadastroDoPedido()
    {
        $this->dadosPedido = '{
            "cpf": "",
            "produtos": [
                {
                    "id": 2,
                    "nome": "Produto 1",
                    "descricao": "Descrição do Produto 1",
                    "preco": 20.99,
                    "categoria": "lanche"
                },
                 {
                    "id": 3,
                    "nome": "Produto 2",
                    "descricao": "Descrição do Produto 2",
                    "preco": 15.99,
                    "categoria": "bebida"
                }
            ]
        }';
    }

    /**
     * @When eu chamar a função de cadastrar pedido com CPF vazio
     */
    public function euChamarAFuncaoDeCadastrarPedidoComCpfVazio()
    {
        try {
            $dadosPedido = json_decode($this->dadosPedido, true);
            $this->idPedido = $this->pedidoController->cadastrar($this->dbConnection, $dadosPedido);
        } catch (Exception $e) {
            $this->exceptionMessage = $e->getMessage();
            $this->exceptionCode = $e->getCode();
        }
    }

    /**
     * @Then eu devo receber uma resposta indicando que o CPF é obrigatório
     */
    public function euDevoReceberUmaRespostaIndicandoQueOCpfEObrigatorio()
    {
        $this->assertEquals("O campo cpf é obrigatório.", $this->exceptionMessage);
        $this->assertEquals(400, $this->exceptionCode);
    }

    /**
     * @Given que existe um ID de pedido válido
     */
    public function queExisteUmIdDePedidoValido()
    {
        $this->dadosPedido = '{
            "cpf": "42157363823",
            "produtos": [
                {
                    "id": 2,
                    "nome": "Produto 1",
                    "descricao": "Descrição do Produto 1",
                    "preco": 20.99,
                    "categoria": "lanche"
                },
                 {
                    "id": 3,
                    "nome": "Produto 2",
                    "descricao": "Descrição do Produto 2",
                    "preco": 15.99,
                    "categoria": "bebida"
                }
            ]
        }';
        $dadosPedido = json_decode($this->dadosPedido, true);
        $this->idPedido = $this->pedidoController->cadastrar($this->dbConnection, $dadosPedido);
    }

    /**
     * @When eu chamar a função excluir pedido
     */
    public function euChamarAFuncaoExcluirPedido()
    {
        $this->resultado = $this->pedidoController->excluir($this->dbConnection, $this->idPedido);
    }

    /**
     * @Then eu devo receber uma resposta indicando que o pedido foi excluído com sucesso
     */
    public function euDevoReceberUmaRespostaIndicandoQueOPedidoFoiExcluidoComSucesso()
    {
        $this->assertTrue($this->resultado);
    }

    /**
     * @Given que existe um ID de pedido inválido
     */
    public function queExisteUmIdDePedidoInvalido()
    {
        $this->idPedido = 99999999999999999;
    }

    /**
     * @When eu chamar a função excluir pedido com id de pedido inválido
     */
    public function euChamarAFuncaoExcluirPedidoComIdDePedidoInvalido()
    {
        $this->resultado = $this->pedidoController->excluir($this->dbConnection, $this->idPedido);
    }

    /**
     * @Then eu devo receber uma resposta indicando que o pedido não foi encontrado
     */
    public function euDevoReceberUmaRespostaIndicandoQueOPedidoNaoFoiEncontrado()
    {
        $this->assertEquals("Não foi encontrado um pedido com o ID informado.", $this->exceptionMessage);
        $this->assertEquals(400, $this->exceptionCode);
    }

    /**
     * @Given que existem pedidos registrados no sistema
     */
    public function queExistemPedidosRegistradosNoSistema()
    {
        $this->dadosPedido = '{
            "cpf": "42157363823",
            "produtos": [
                {
                    "id": 2,
                    "nome": "Produto 1",
                    "descricao": "Descrição do Produto 1",
                    "preco": 20.99,
                    "categoria": "lanche"
                },
                 {
                    "id": 3,
                    "nome": "Produto 2",
                    "descricao": "Descrição do Produto 2",
                    "preco": 15.99,
                    "categoria": "bebida"
                }
            ]
        }';
        $dadosPedido = json_decode($this->dadosPedido, true);
        $this->idPedido = $this->pedidoController->cadastrar($this->dbConnection, $dadosPedido);
        $this->assertIsInt($this->idPedido);
    }

    /**
     * @When eu chamar a função obterPedidos
     */
    public function euChamarAFuncaoObterpedidos()
    {
        $this->pedidos = $this->pedidoController->obterPedidos($this->dbConnection);
    }

    /**
     * @Then eu devo receber uma lista de todos os pedidos existentes
     */
    public function euDevoReceberUmaListaDeTodosOsPedidosExistentes()
    {
        $this->assertArrayHasKey("idPedido", $this->pedidos[0]);
        $pedidoExcluido = $this->pedidoController->excluir($this->dbConnection, $this->idPedido);
        $this->assertTrue($pedidoExcluido);
    }

    /**
     * @Then eu devo receber uma lista de pedidos vazia
     */
    public function euDevoReceberUmaListaDePedidosVazia()
    {
        $this->assertEquals([], $this->pedidos);
    }

    /**
     * @Given que existe um ID de pedido válido e um novo status
     */
    public function queExisteUmIdDePedidoValidoEUmNovoStatus()
    {
        $dadosPedido = '{
            "cpf": "42157363823",
            "produtos": [
                {
                    "id": 2,
                    "nome": "Produto 1",
                    "descricao": "Descrição do Produto 1",
                    "preco": 20.99,
                    "categoria": "lanche"
                },
                 {
                    "id": 3,
                    "nome": "Produto 2",
                    "descricao": "Descrição do Produto 2",
                    "preco": 15.99,
                    "categoria": "bebida"
                }
            ]
        }';

        $dadosValidos = json_decode($dadosPedido, true);
        $this->idPedido = $this->pedidoController->cadastrar($this->dbConnection, $dadosValidos);
        $this->assertIsInt($this->idPedido);
    }

    /**
     * @When eu chamar a função atualizarStatusPedido
     */
    public function euChamarAFuncaoAtualizarstatuspedido()
    {
        $novoStatus = "em_preparacao";
        $this->resultado = $this->pedidoController->atualizarStatusPedido($this->producaoMySqlConnection, $this->idPedido, $novoStatus);
        $this->assertTrue($this->resultado);
    }

    /**
     * @Then eu devo receber uma resposta indicando que o status do pedido foi atualizado com sucesso
     */
    public function euDevoReceberUmaRespostaIndicandoQueOStatusDoPedidoFoiAtualizadoComSucesso()
    {
        $this->assertTrue($this->resultado);
        $pedidoExcluido = $this->pedidoController->excluir($this->dbConnection, $this->idPedido);
        $this->assertTrue($pedidoExcluido);
    }

    /**
     * @Given que existe um ID de pedido inválido e um novo status
     */
    public function queExisteUmIdDePedidoInvalidoEUmNovoStatus()
    {
        $this->idPedido = 999999999999999999;
        $this->novoStatusPedido = "em_preparacao";
    }

    /**
     * @Given que não existem pedidos registrados no sistema
     */
    public function queNaoExistemPedidosRegistradosNoSistema()
    {
        $this->pedidos = [];
    }

    /**
     * @When eu chamar a função obterPedidos e não tiver pedidos no sistema
     */
    public function euChamarAFuncaoObterpedidosENaoTiverPedidosNoSistema()
    {
        $this->pedidos = [];
    }

    /**
     * @When eu chamar a função atualizarStatusPedido com o id de pedido inválido
     */
    public function euChamarAFuncaoAtualizarstatuspedidoComOIdDePedidoInvalido()
    {
        try {
            $this->PedidoController->atualizarStatusPedido($this->producaoMySqlConnection, $this->idPedido, $this->novoStatusPedido);
        } catch (Exception $e) {
            $this->exceptionMessage = $e->getMessage();
            $this->exceptionCode = $e->getCode();
        }
    }

    /**
     * @Then eu devo receber false como resposta
     */
    public function euDevoReceberFalseComoResposta()
    {
        $this->assertFalse($this->resultado);
    }
}
