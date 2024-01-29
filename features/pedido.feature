Feature: Funcionalidades do PedidoController

  Scenario: Cadastrar pedido com dados válidos
    Given que existem dados válidos para cadastro
    When eu chamar a função de cadastrar pedido
    Then eu devo receber o ID do pedido cadastrado

  Scenario: Cadastrar pedido sem CPF
    Given que não há CPF fornecido para o cadastro do pedido
    When eu chamar a função de cadastrar pedido com CPF vazio
    Then eu devo receber uma resposta indicando que o CPF é obrigatório

  Scenario: Excluir pedido existente
    Given que existe um ID de pedido válido
    When eu chamar a função excluir pedido
    Then eu devo receber uma resposta indicando que o pedido foi excluído com sucesso

  Scenario: Excluir pedido inexistente
    Given que existe um ID de pedido inválido
    When eu chamar a função excluir pedido com id de pedido inválido
    Then eu devo receber false como resposta