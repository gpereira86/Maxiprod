# Sistema de Controle de Gastos Residenciais

Este é um sistema de controle de gastos residenciais simples que permite o cadastro de pessoas, transações financeiras e a consulta de totais de receitas, despesas e saldos. O objetivo do projeto é gerenciar de forma eficiente as finanças pessoais, com funcionalidades para registrar e consultar transações de diferentes pessoas e calcular o saldo geral.


## Tecnologias Utilizadas 

Sistema desenvolvido em PHP 8.4 utilizando arquiterura MVC


- **Back-end**: PHP 8.4 (para o gerenciamento de dados e lógica do sistema).
- **Front-end**: HTML, CSS e Javascript (para exibição e interação com usuário)
- **Armazenamento de Dados**: Os dados são armazenados em um banco de dados MySql pelo PHPmyadmin.

> #### **Bibliotecas PHP utilizadas:** 
> - DotEnv (vlucas/phpdotenv)
> - Twig Template (twig/twig)
> - Fast Route (nikic/fast-route)

## Funcionalidades

- **Home**: Listagem de transações, totalizador de transação, totalizador de pessoas cadastradas e filtro de transações por pessoa.


- **Cadastro de Pessoas**: Criação, listagem, edição e exclusão de pessoas. Ao deletar uma pessoa, todas as suas transações são removidas automaticamente.


- **Cadastro de Transações**: Adição, listagem, edição e exclusão de transações financeiras, com descrição, valor, tipo (despesa ou receita) e a associação a uma pessoa. Caso a pessoa seja menor de idade (menos de 18 anos), apenas despesas são permitidas.


- **Totais**: Exibe o total de receitas, despesas e saldo (receita - despesa) para cada pessoa cadastrada. Também calcula o total geral de receitas, despesas e saldo líquido de todas as pessoas.


## Como Executar

1. Clone o repositório:
   ```
   git clone https://github.com/gpereira86/Maxiprod.git
   ```


2. Acesse o diretório do projeto:
   ```
   cd seu-diretorio-local
   ```
   

3. Se você estiver utilizando um servidor local (como o XAMPP ou WAMP), coloque os arquivos na pasta `htdocs` (ou equivalente).
   

4. Antes de começar a usar, realizar as configurações iniciais:
   - Criar banco de dados utilizando o dump do banco disponibilizado no aquivo sql `dump_bd.sql` na pasta `documentacao` [acesse aqui o arquivo](documentacao/dump_bd.sql);
   - Configure as variáveis de sistema (constantes) no arquivo `config.php` dentro da pasta `system` [acesse aqui o arquivo](system/config.php);
   - No arquivo `.htaccess`, altere o rewrite de `/maxiprod/` para `/seu-diretorio-local/`;
   - Caso não tenha o composer instalado, instale. Página oficial com detalhes: https://getcomposer.org/doc/00-intro.md, ou basta procurar no youtube como fazer;
   - Realize o dump do autoload pelo terminal (necessário estar no caminho raiz do projeto) com o comando `composer dump-autoload` para ter certeza de que irá funcionar: 


5. Abra o navegador e acesse o endereço do seu projeto:
   ```
   http://localhost/seu-diretorio-local
   ```

## Observações

- O projeto foi desenvolvido para fins de demonstração e aprendizado, sendo necessário melhorias para uso em produção.
- Comentários e documentação estão presentes no código para explicar a lógica implementada.
