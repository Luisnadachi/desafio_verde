# Desafio API de Transferência

## Problema

O desafio consistia na criação de uma API de transferência com a utilização de PHP ou de qualquer framework dele. As
regras de negócio levantadas foram as seguintes:

- Existem 2 tipos de usuários, comuns e lojistas, ambos com carteiras que realizam transferência.
- Os dois tipos vão ter os seguintes dados: Nome, email, cpf/cnpj, senha. Dentre eles, email e cpf/cnpj tem que ser únicos.
- Usuários comuns podem enviar dinheiro para lojista ou para Usuário comum.
- Lojistas só recebem, não transferem.
- Validar se o Usuário tem saldo na conta.
- A operação de transferência deve ser uma transação, ou seja, revertida em caso de qualquer inconsistência.
- Consultar um serviço autorizador externo.
- No recebimento do pagamento, o usuário ou lojista precisa receber uma notificação.
- O serviço deve ser RESTFul.

## Resolução do Problema

Colocarei alguns pontos importantes pra facilitar na explicação do projeto.

### Modelagem

* Tanto quanto o usuário quanto lojista precisa de uma carteira para enviar o dinheiro entre si, então preferi criar uma
  tabela para carteiras e referenciar como chave estrangeira;
* Também utilizei Uuid como chave primária das tabelas para
  trazer uma maior segurança pois estamos lidando com transações financeiras e a última coisa que eu gostaria era
  facilitar um Brute Force;
* No CPF, CNPJ e E-mail eu apenas coloquei o atributo `unique()` e já resolveu um dos problemas propostos;
* Utilizei como complemento os Observers para segregar a responsabilidade da Model de inserção do uuid.
* Optei por utilizar inteiro para tratar valores monetários porque não gostaria que durante uma transação houvesse uma imprecisão do valor.

Exemplo de tradução de decimal para inteiro
```
R$500.00 = 50000
R$435.32 = 43532
R$752.14 = 75214
```

Modelagem do banco de dados
```
table: users
id: string PK
name: string
cpf: string UK
email: string UK
password: string

table: shopkeepers
id: string PK
name: string 
cnpj: string UK
email: string UK
password: string

table: wallets
id: string
owner_id: string FK (User, Shopkeeper) -> id
balance: int

table: transactions
id: string PK
payer_id: string FK (Wallet) -> id
payee_id: string FK (Wallet) -> id
amount: int
```
### Testes

Criei o BDD para idealizar os comportamentos antes de começar o TDD no qual não consegui terminar todos os testes, mas foi o que consegui idealizar por agora.

* Descrição: Feature responsável pelas transferências bancárias no sistema.
* Modo De Usar: Acessar a página de transferências bancárias e tentar efetuar uma transferência para outra conta.
* Regras:
    * Transferências de `Usuário` para `Usuário`
    * Transferências de `Usuário` para `Lojista`
    * `Usuário` deve obrigatóriamente possuir `saldo` disponível na `carteira`.
    * O serviço autorizador externo deve permitir a transferência para que ela seja concluída.
* BDD:
    * Cenário Positivo:
        * Given: Um usuário faz transferências para `Usuário` ou `Lojista`.
        * When: Processar uma transferência de uma carteira com `saldo` disponível.
        * Then: Verificar se existe saldo na carteira.
        * Then: Consulta verificador externo.
        * Then: Subtrai o valor da transferência da carteira origem.
        * Then: Enviar notificação.
        * Then: Efetuar transferência.
    * Cenário Negativo 1:
        * Given: Um `Lojista` tenta fazer uma transferência.
        * When: Processar uma transferência de uma carteira com `saldo` disponível.
        * Then: Verificar se é `Lojista`.
        * Then: Retornar mensagem: `Lojistas não tem autorização para realizar transferências`.
    * Cenário Negativo 2:
        * Given: Um usuário não possui `saldo` disponível na carteira.
        * When: Processar uma transferência de uma carteira onde o valor da transferência é maior que o `saldo` disponível.
        * Then: Retornar uma mensagem de erro: `Você não possui saldo disponível na sua carteira para a realização desta transferência.`
    * Cenário Negativo 3:
        * Given: O serviço autorizador nega o processo de transferência.
        * When: Processar uma transferência de uma carteira com `saldo` disponível.
        * Then: Retornar mensagem: `Não autorizado`.

## Como rodar o projeto

```
1 - git clone git@github.com:Luisnadachi/desafio_verde.git
2 - composer install
3 - Renomear .env.example para .env
4 - Substituir os dados do banco no .env
```

## Como rodar os testes

Utilizei a própria lib de testes do laravel.

```
$ php artisan test
```

## Como rodar verificação do codigo

```
vendor/bin/phpmd app text cleancode,codesize,controversial,design,naming,unusedcode
```

## Referências

[Laravel doc](https://laravel.com/docs/9.x)  
[Why not use Double or Float to represent currency?](https://stackoverflow.com/questions/3730019/why-not-use-double-or-float-to-represent-currency)  
[Refactoring Guru](https://refactoring.guru)  
[Exceptions](https://www.rosstuck.com/formatting-exception-messages)

