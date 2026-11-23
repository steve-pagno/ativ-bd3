<?php
require_once __DIR__ . '/config.php';

// Faz o mysqli lançar exceções quando ocorrer erro
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

/**
 * Retorna a conexão com o banco (abre só uma vez por requisição).
 */
function conectar()
{
    static $conexao = null;

    if ($conexao === null) {
        $conexao = mysqli_connect(DB_HOST, DB_USUARIO, DB_SENHA, DB_NOME);
        mysqli_set_charset($conexao, 'utf8mb4');
    }

    return $conexao;
}
