<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($titulo ?? 'Condomínio') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="index.php">Condomínio</a>
        <div>
            <a class="btn btn-outline-light btn-sm" href="pagadores.php">Pagadores</a>
            <a class="btn btn-outline-light btn-sm" href="unidades.php">Unidades</a>
            <a class="btn btn-outline-light btn-sm" href="pagamentos.php">Pagamentos</a>
            <a class="btn btn-outline-light btn-sm" href="comprovante.php">Baixar comprovante</a>
            <a class="btn btn-light btn-sm" href="https://github.com/steve-pagno/ativ-bd3" target="_blank" rel="noopener">Repositório no GitHub</a>
        </div>
    </div>
</nav>
<div class="container">

<?php $mensagem = pegar_mensagem(); ?>
<?php if ($mensagem): ?>
    <div class="alert alert-<?= e($mensagem['tipo']) ?>"><?= e($mensagem['texto']) ?></div>
<?php endif; ?>
