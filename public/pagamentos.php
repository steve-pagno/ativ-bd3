<?php
require_once __DIR__ . '/../app/funcoes.php';
require_once __DIR__ . '/../app/modelos/pagamento.php';
require_once __DIR__ . '/../app/modelos/pagador.php';
require_once __DIR__ . '/../app/modelos/unidade.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (isset($_POST['inserir'])) {
            $id_pagador     = (int) $_POST['id_pagador'];
            $id_unidade     = (int) $_POST['id_unidade'];
            $data_pagamento = $_POST['data_pagamento'];
            $ano            = (int) $_POST['ano'];
            $mes            = (int) $_POST['mes'];
            $arquivo        = $_FILES['comprovante'];

            if ($arquivo['error'] !== UPLOAD_ERR_OK) {
                definir_mensagem('Erro no envio do arquivo.', 'danger');
            } elseif ($mes < 1 || $mes > 12) {
                definir_mensagem('Mês de referência inválido.', 'warning');
            } else {
                $comprovante = file_get_contents($arquivo['tmp_name']);

                // Todo PDF começa com "%PDF"
                if (substr($comprovante, 0, 4) !== '%PDF') {
                    definir_mensagem('O comprovante precisa ser um arquivo PDF.', 'warning');
                } else {
                    inserir_pagamento($id_pagador, $data_pagamento, $comprovante, $ano, $mes, $id_unidade);
                    definir_mensagem('Pagamento cadastrado!');
                }
            }
        }

        if (isset($_POST['excluir'])) {
            if (excluir_pagamento((int) $_POST['id'])) {
                definir_mensagem('Pagamento excluído!');
            } else {
                definir_mensagem('Nenhum pagamento com esse código.', 'warning');
            }
        }
    } catch (mysqli_sql_exception $erro) {
        definir_mensagem(mensagem_erro_banco($erro), 'danger');
    }

    redirecionar('pagamentos.php');
}

$pagamentos = listar_pagamentos();
$pagadores  = listar_pagadores();
$unidades   = listar_unidades();

$titulo = 'Pagamentos';
require __DIR__ . '/../app/views/cabecalho.php';
?>

<h2>Pagamentos</h2>

<div class="row">
    <div class="col-md-6">
        <h4>Novo pagamento</h4>

        <?php if (empty($pagadores) || empty($unidades)): ?>
            <div class="alert alert-warning">
                Cadastre ao menos um <a href="pagadores.php">pagador</a> e uma
                <a href="unidades.php">unidade</a> antes de registrar pagamentos.
            </div>
        <?php else: ?>
            <form method="post" enctype="multipart/form-data">
                <div class="mb-2">
                    <label class="form-label">Pagador</label>
                    <select name="id_pagador" class="form-select" required>
                        <?php foreach ($pagadores as $pagador): ?>
                            <option value="<?= e($pagador['id']) ?>">
                                <?= e($pagador['id'] . ' - ' . $pagador['nome']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-2">
                    <label class="form-label">Unidade</label>
                    <select name="id_unidade" class="form-select" required>
                        <?php foreach ($unidades as $unidade): ?>
                            <option value="<?= e($unidade['id']) ?>">
                                <?= e($unidade['numero'] . ' - ' . $unidade['localizacao']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-2">
                    <label class="form-label">Data do pagamento</label>
                    <input type="date" name="data_pagamento" class="form-control" required>
                </div>
                <div class="row mb-2">
                    <div class="col">
                        <label class="form-label">Ano de referência</label>
                        <input type="number" name="ano" class="form-control" min="2000" max="2100" required>
                    </div>
                    <div class="col">
                        <label class="form-label">Mês de referência</label>
                        <input type="number" name="mes" class="form-control" min="1" max="12" required>
                    </div>
                </div>
                <div class="mb-2">
                    <label class="form-label">Comprovante (PDF)</label>
                    <input type="file" name="comprovante" class="form-control" accept="application/pdf" required>
                </div>
                <button type="submit" name="inserir" class="btn btn-primary">Cadastrar</button>
            </form>
        <?php endif; ?>
    </div>

    <div class="col-md-6">
        <h4>Excluir pagamento</h4>
        <form method="post">
            <div class="mb-2">
                <label class="form-label">Código do pagamento</label>
                <input type="number" name="id" class="form-control" min="1" required>
            </div>
            <button type="submit" name="excluir" class="btn btn-danger">Excluir</button>
        </form>
    </div>
</div>

<h4 class="mt-4">Lista de pagamentos</h4>
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Código</th>
            <th>Pagador</th>
            <th>Data pagamento</th>
            <th>Comprovante</th>
            <th>Ano ref.</th>
            <th>Mês ref.</th>
            <th>Unidade</th>
            <th>Data registro</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($pagamentos as $pagamento): ?>
            <tr>
                <td><?= e($pagamento['id']) ?></td>
                <td><?= e($pagamento['pagador']) ?></td>
                <td><?= e(formatar_data($pagamento['data_pagamento'])) ?></td>
                <td><a href="baixar.php?id=<?= e($pagamento['id']) ?>">PDF</a></td>
                <td><?= e($pagamento['ano_referencia']) ?></td>
                <td><?= e($pagamento['mes_referencia']) ?></td>
                <td><?= e($pagamento['id_unidade']) ?></td>
                <td><?= e(formatar_data_hora($pagamento['data_registro'])) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require __DIR__ . '/../app/views/rodape.php'; ?>
