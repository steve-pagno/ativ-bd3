<?php

function listar_unidades()
{
    $resultado = mysqli_query(conectar(), 'SELECT * FROM unidade ORDER BY id');
    return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
}

function inserir_unidade($numero, $localizacao)
{
    $stmt = mysqli_prepare(conectar(), 'CALL sp_inserir_unidade(?, ?)');
    mysqli_stmt_bind_param($stmt, 'ss', $numero, $localizacao);
    mysqli_stmt_execute($stmt);
}

/**
 * Retorna true se algum registro foi excluído.
 */
function excluir_unidade($id)
{
    $stmt = mysqli_prepare(conectar(), 'CALL sp_excluir_unidade(?)');
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_affected_rows($stmt) > 0;
}
