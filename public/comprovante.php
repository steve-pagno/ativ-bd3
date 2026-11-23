<?php
require_once __DIR__ . '/../app/funcoes.php';

$titulo = 'Baixar comprovante';
require __DIR__ . '/../app/views/cabecalho.php';
?>

<h2>Baixar comprovante</h2>

<form method="get" action="baixar.php" class="col-md-4">
    <div class="mb-2">
        <label class="form-label">Código do pagamento</label>
        <input type="number" name="id" class="form-control" min="1" required>
    </div>
    <button type="submit" class="btn btn-success">Baixar</button>
</form>

<?php require __DIR__ . '/../app/views/rodape.php'; ?>
