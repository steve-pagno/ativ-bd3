<?php
require_once __DIR__ . '/../app/funcoes.php';

$titulo = 'Início';
require __DIR__ . '/../app/views/cabecalho.php';
?>

<h2>Sistema de Pagamentos de Condomínio</h2>
<p>Escolha uma opção:</p>

<div class="list-group col-md-4">
    <a class="list-group-item list-group-item-action" href="pagadores.php">Pagadores</a>
    <a class="list-group-item list-group-item-action" href="unidades.php">Unidades</a>
    <a class="list-group-item list-group-item-action" href="pagamentos.php">Pagamentos</a>
    <a class="list-group-item list-group-item-action" href="comprovante.php">Baixar comprovante</a>
</div>

<?php require __DIR__ . '/../app/views/rodape.php'; ?>
