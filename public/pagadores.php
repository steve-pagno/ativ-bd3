<?php
require_once __DIR__ . '/../app/funcoes.php';
require_once __DIR__ . '/../app/modelos/pagador.php';

// Trata os formulários e redireciona (evita reenvio ao atualizar a página)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (isset($_POST['inserir'])) {
            $nome      = trim($_POST['nome']);
            $email     = trim($_POST['email']);
            $documento = trim($_POST['documento']);
            $telefone  = trim($_POST['telefone']);

            if ($nome === '' || $documento === '' || $telefone === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                definir_mensagem('Preencha todos os campos corretamente.', 'warning');
            } else {
                inserir_pagador($nome, $email, $documento, $telefone);
                definir_mensagem('Pagador cadastrado!');
            }
        }

        if (isset($_POST['excluir'])) {
            if (excluir_pagador((int) $_POST['id'])) {
                definir_mensagem('Pagador excluído!');
            } else {
                definir_mensagem('Nenhum pagador com esse código.', 'warning');
            }
        }
    } catch (mysqli_sql_exception $erro) {
        definir_mensagem(mensagem_erro_banco($erro), 'danger');
    }

    redirecionar('pagadores.php');
}

$pagadores = listar_pagadores();

$titulo = 'Pagadores';
require __DIR__ . '/../app/views/cabecalho.php';
?>

<h2>Pagadores</h2>

<div class="row">
    <div class="col-md-6">
        <h4>Novo pagador</h4>
        <form method="post">
            <div class="mb-2">
                <label class="form-label">Nome completo</label>
                <input type="text" name="nome" class="form-control" maxlength="150" required>
            </div>
            <div class="mb-2">
                <label class="form-label">E-mail</label>
                <input type="email" name="email" class="form-control" maxlength="150" required>
            </div>
            <div class="mb-2">
                <label class="form-label">Documento de identificação</label>
                <input type="text" name="documento" class="form-control" maxlength="30" required>
            </div>
            <div class="mb-2">
                <label class="form-label">Telefone</label>
                <input type="text" name="telefone" class="form-control" maxlength="20" required>
            </div>
            <button type="submit" name="inserir" class="btn btn-primary">Cadastrar</button>
        </form>
    </div>

    <div class="col-md-6">
        <h4>Excluir pagador</h4>
        <form method="post">
            <div class="mb-2">
                <label class="form-label">Código do pagador</label>
                <input type="number" name="id" class="form-control" min="1" required>
            </div>
            <button type="submit" name="excluir" class="btn btn-danger">Excluir</button>
        </form>
    </div>
</div>

<h4 class="mt-4">Lista de pagadores</h4>
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Código</th>
            <th>Nome</th>
            <th>E-mail</th>
            <th>Documento</th>
            <th>Telefone</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($pagadores as $pagador): ?>
            <tr>
                <td><?= e($pagador['id']) ?></td>
                <td><?= e($pagador['nome']) ?></td>
                <td><?= e($pagador['email']) ?></td>
                <td><?= e($pagador['documento']) ?></td>
                <td><?= e($pagador['telefone']) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require __DIR__ . '/../app/views/rodape.php'; ?>
