# Trabalho M3 - Pagamentos de Condomínio (PHP + MySQL)

## Estrutura

```
banco/banco.sql        tabelas, trigger e stored procedures
app/config.exemplo.php modelo do arquivo de acesso ao banco (config.php)
app/conexao.php        abre a conexão (mysqli)
app/funcoes.php        funções auxiliares (mensagens, escape de HTML, datas)
app/modelos/           acesso ao banco de cada entidade
app/views/             cabeçalho e rodapé das páginas
public/                páginas acessadas pelo navegador
```

## Como rodar

1. Crie o banco: `mysql -u root -p < banco/banco.sql`
2. Copie `app/config.exemplo.php` para `app/config.php` e ajuste usuário e senha.
3. Inicie o servidor: `php -S localhost:8000 -t public`
4. Acesse http://localhost:8000

Requisitos: PHP 7.4+ com a extensão `mysqli`.
