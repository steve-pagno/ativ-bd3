<?php
session_start();

require_once __DIR__ . '/conexao.php';

/**
 * Escapa um texto para exibir no HTML com segurança.
 */
function e($texto)
{
    return htmlspecialchars((string) $texto, ENT_QUOTES, 'UTF-8');
}

/**
 * Guarda uma mensagem para ser exibida na próxima página.
 * $tipo: success, danger, warning...
 */
function definir_mensagem($texto, $tipo = 'success')
{
    $_SESSION['mensagem'] = ['texto' => $texto, 'tipo' => $tipo];
}

/**
 * Retorna a mensagem guardada (e apaga da sessão).
 */
function pegar_mensagem()
{
    if (!isset($_SESSION['mensagem'])) {
        return null;
    }

    $mensagem = $_SESSION['mensagem'];
    unset($_SESSION['mensagem']);
    return $mensagem;
}

function redirecionar($pagina)
{
    header('Location: ' . $pagina);
    exit;
}

/**
 * Traduz os erros mais comuns do MySQL para uma mensagem amigável.
 */
function mensagem_erro_banco(mysqli_sql_exception $erro)
{
    if ($erro->getCode() == 1451) {
        return 'Não é possível excluir: existem pagamentos vinculados a este registro.';
    }
    if ($erro->getCode() == 1452) {
        return 'Pagador ou unidade informados não existem.';
    }
    return 'Erro no banco de dados: ' . $erro->getMessage();
}

function formatar_data($data)
{
    return date('d/m/Y', strtotime($data));
}

function formatar_data_hora($data)
{
    return date('d/m/Y H:i:s', strtotime($data));
}
