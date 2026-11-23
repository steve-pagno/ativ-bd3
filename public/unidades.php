<?php
require_once __DIR__ . '/../app/funcoes.php';
require_once __DIR__ . '/../app/modelos/unidade.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (isset($_POST['inserir'])) {
            $numero      = trim($_POST['numero']);
            $localizacao = trim($_POST['localizacao']);

            if ($numero === '' || $localizacao === '') {
                definir_mensagem('Preencha todos os campos.', 'warning');
            } else {
                inserir_unidade($numero, $localizacao);
                definir_mensagem('Unidade cadastrada!');
            }
        }

        if (isset($_POST['excluir'])) {
            if (excluir_unidade((int) $_POST['id'])) {
                definir_mensagem('Unidade excluída!');
            } else {
                definir_mensagem('Nenhuma unidade com esse código.', 'warning');
            }
        }
    } catch (mysqli_sql_exception $erro) {
        definir_mensagem(mensagem_erro_banco($erro), 'danger');
    }

    redirecionar('unidades.php');
}

$unidades = listar_unidades();

$titulo = 'Unidades';
require __DIR__ . '/../app/views/cabecalho.php';
?>

<h2>Unidades</h2>

<div class="row">
    <div class="col-md-6">
        <h4>Nova unidade</h4>
        <form method="post">
            <div class="mb-2">
                <label class="form-label">Número</label>
                <input type="text" name="numero" class="form-control" maxlength="20" required>
            </div>
            <div class="mb-2">
                <label class="form-label">Localização (ex.: primeiro andar, bloco 2)</label>
                <input type="text" name="localizacao" class="form-control" maxlength="150" required>
            </div>
            <button type="submit" name="inserir" class="btn btn-primary">Cadastrar</button>
        </form>
    </div>

    <div class="col-md-6">
        <h4>Excluir unidade</h4>
        <form method="post">
            <div class="mb-2">
                <label class="form-label">Código da unidade</label>
                <input type="number" name="id" class="form-control" min="1" required>
            </div>
            <button type="submit" name="excluir" class="btn btn-danger">Excluir</button>
        </form>
    </div>
</div>

<h4 class="mt-4">Lista de unidades</h4>
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Código</th>
            <th>Número</th>
            <th>Localização</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($unidades as $unidade): ?>
            <tr>
                <td><?= e($unidade['id']) ?></td>
                <td><?= e($unidade['numero']) ?></td>
                <td><?= e($unidade['localizacao']) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require __DIR__ . '/../app/views/rodape.php'; ?>
