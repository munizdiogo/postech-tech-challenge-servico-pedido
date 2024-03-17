# Tech Challenge - Sistema de Lanchonete - Serviço: Produção

Esta documentação tem o intuito de orientar sobre a configuração e utilização correta do sistema de lanchonete para o serviço: Produção, que é responsável por acompanhar a produção/fila de pedidos e atualização de status dos pedidos.


## Infraestrutura
Toda a infraestrutura (cluster, banco de dados, imagem, etc) está vinculada aos serviços AWS, e é criada através dos workflows com o nome "pipeline-producao" dentro do Github Actions dos seguintes repositórios: 

**Infraestrutura da Aplicação:**  
https://github.com/munizdiogo/postech-tech-challenge-infra-kubernetes-terraform

**Infraestrutura do Banco de Dados:**  
https://github.com/munizdiogo/postech-tech-challenge-infra-database-terraform

**Funções Lambda:**  
Devem ser criadas manualmente inicialmente, as atualizações serão feitas de forma automatizada pelo CI/CD (no Github Actions), porém a criação é realizada diretamente no AWS Lambda. 

Dessa forma, basta executar o workflow que todo a infraestrutura será gerada automaticamente (o build é realizado apenas na primeira vez, após isso é necessário comentar no workflow o job build e deixar apenas o job deploy ativo).

**IMPORTANTE:** Verificar se valor das SECRETS estão de acordo com os valores da AWS. 


## Como acessar

**Aplicação:**  
É necessário a criação de uma API no AWS API Gateway, e realização das configurações de rota, ao final da configuração será disponibilizado um endpoint para que seja realizada as requisições. 

**Banco de dados:**  
Acesse o painel da Amazon RDS ao clicar no banco de dados desejado você visualizará um endpoint para que possa usar como host no momento da conexão com o banco de dados.

## Endpoints

Após a criação da infraestrutura, funções lambda e configuração no AWS API Gateway, você conseguirá realizar as requisições HTTP conforme a documentação:
[Requisições HTTP - Exemplos](https://documenter.getpostman.com/view/14275027/2s93zCXzjp)


## Justificativa do padrão SAGA escolhido

Foi definido de usar o padrão SAGA coreografado devido ter maior facilidade e rapidez para implementação. 
Como a equipe é pequena e o projeto não é grande, fazer de forma distribuída de modo que cada serviço não tenha alto acoplamento tornou o desenvolvimento mais prático e tivemos poucas falhas nas entregas. 
Nós tivemos como trabalhar em cada serviço individualmente e ir avançando para o próximo conforme fosse finalizado. E quando precisamos atuar em alguma atualização ou manutenção do código, obtivemos maior eficiência.

O modelo coreografado tem como vantagens a Organização Distribuída, Desacoplamento e a Tolerância a falhas.


## Documentação

[Fluxograma - Preparação do pedido e entrega do pedido](https://miro.com/app/board/uXjVMAaDj1g=/?share_link_id=766010607812)

[Fluxograma - Realização do Pedido e Pagamento](https://miro.com/app/board/uXjVMAbdRp0=/?share_link_id=567814725228)

[Fluxograma - Desenho da arquitetura na AWS](https://drive.google.com/file/d/1i15Mkyfl9b_9toiNlsdDFJxbn7GEup0e)

[Fluxograma - Desenho do fluxo de comunicação SAGA](https://drive.google.com/file/d/1bDKpEPGBX1omtp8f4XowbuvKce51iYhY/view?usp=sharing)

[Requisições HTTP - Exemplos](https://documenter.getpostman.com/view/14275027/2s93zCXzjp)
