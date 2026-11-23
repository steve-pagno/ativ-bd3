<?php
require_once __DIR__ . '/../app/funcoes.php';
require_once __DIR__ . '/../app/modelos/pagamento.php';

$id = (int) ($_GET['id'] ?? 0);
$comprovante = buscar_comprovante($id);

if ($comprovante === null) {
    definir_mensagem('Pagamento não encontrado.', 'danger');
    redirecionar('comprovante.php');
}

// Envia o PDF para o navegador baixar (RF4)
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="comprovante_' . $id . '.pdf"');
header('Content-Length: ' . strlen($comprovante));
echo $comprovante;
