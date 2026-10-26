<?php
session_start();
require_once __DIR__ . '/config/conexao.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

// Validação do token CSRF
$token = $_POST['csrf_token'] ?? '';
if (!hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
    http_response_code(403);
    exit('Requisição inválida.');
}

// Valida o ID como inteiro positivo
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);

// Whitelist: só aceita os status previstos no sistema
$statusPermitidos = ['Aberto', 'Em Andamento', 'Resolvido'];
$status = $_POST['status'] ?? '';

if (!$id || !in_array($status, $statusPermitidos, true)) {
    $_SESSION['flash'] = ['tipo' => 'danger', 'texto' => 'Dados inválidos para atualização.'];
    header('Location: index.php');
    exit;
}

try {
    $stmt = $pdo->prepare('UPDATE chamados SET status = :status WHERE id = :id');
    $stmt->execute([
        ':status' => $status,
        ':id'     => $id,
    ]);

    $_SESSION['flash'] = ['tipo' => 'success', 'texto' => "Chamado #{$id} atualizado para \"{$status}\"."];
} catch (PDOException $e) {
    error_log('Erro ao atualizar status: ' . $e->getMessage());
    $_SESSION['flash'] = ['tipo' => 'danger', 'texto' => 'Erro ao atualizar o status.'];
}

header('Location: index.php');
exit;
