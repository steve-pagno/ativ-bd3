<?php

/**
 * RF5: lista ordenada por ano e mês de referência,
 * trocando o código do pagador pelo nome.
 * O BLOB não é carregado aqui para não pesar a listagem.
 */
function listar_pagamentos()
{
    $sql = 'SELECT pg.id, pa.nome AS pagador, pg.data_pagamento,
                   pg.ano_referencia, pg.mes_referencia, pg.id_unidade, pg.data_registro
            FROM pagamento pg
            INNER JOIN pagador pa ON pa.id = pg.id_pagador
            ORDER BY pg.ano_referencia, pg.mes_referencia';

    $resultado = mysqli_query(conectar(), $sql);
    return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
}

function inserir_pagamento($id_pagador, $data_pagamento, $comprovante, $ano, $mes, $id_unidade)
{
    $stmt = mysqli_prepare(conectar(), 'CALL sp_inserir_pagamento(?, ?, ?, ?, ?, ?)');
    mysqli_stmt_bind_param($stmt, 'issiii', $id_pagador, $data_pagamento, $comprovante, $ano, $mes, $id_unidade);
    mysqli_stmt_execute($stmt);
}

/**
 * Retorna true se algum registro foi excluído.
 */
function excluir_pagamento($id)
{
    $stmt = mysqli_prepare(conectar(), 'CALL sp_excluir_pagamento(?)');
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_affected_rows($stmt) > 0;
}

/**
 * Retorna o conteúdo do PDF ou null se o pagamento não existir.
 */
function buscar_comprovante($id)
{
    $stmt = mysqli_prepare(conectar(), 'SELECT comprovante FROM pagamento WHERE id = ?');
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $linha = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

    return $linha ? $linha['comprovante'] : null;
}
