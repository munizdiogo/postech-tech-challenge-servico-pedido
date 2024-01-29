# Tech Challenge - Sistema de Lanchonete

Esta documentação tem o intuito de orientar sobre a configuração e utilização correta do sistema de lanchonete.


## Infraestrutura
Toda a infraestrutura (cluster, banco de dados, imagem, etc) está vinculada aos serviços AWS, e é criada através dos workflows com o nome "Pipeline" dentro do Github Actions dos seguintes repositórios: 

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



## Documentação

[Fluxograma - Realização do Pedido e Pagamento](https://miro.com/app/board/uXjVMAbdRp0=/?share_link_id=567814725228)

[Fluxograma - Preparação do pedido e entrega do pedido](https://miro.com/app/board/uXjVMAaDj1g=/?share_link_id=766010607812)

[Requisições HTTP - Exemplos](https://documenter.getpostman.com/view/14275027/2s93zCXzjp)
