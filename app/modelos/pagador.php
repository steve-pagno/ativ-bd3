<?php

function listar_pagadores()
{
    $resultado = mysqli_query(conectar(), 'SELECT * FROM pagador ORDER BY id');
    return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
}

function inserir_pagador($nome, $email, $documento, $telefone)
{
    $stmt = mysqli_prepare(conectar(), 'CALL sp_inserir_pagador(?, ?, ?, ?)');
    mysqli_stmt_bind_param($stmt, 'ssss', $nome, $email, $documento, $telefone);
    mysqli_stmt_execute($stmt);
}

/**
 * Retorna true se algum registro foi excluído.
 */
function excluir_pagador($id)
{
    $stmt = mysqli_prepare(conectar(), 'CALL sp_excluir_pagador(?)');
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_affected_rows($stmt) > 0;
}
