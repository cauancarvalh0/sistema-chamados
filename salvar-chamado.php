<?php
session_start();
require_once __DIR__ . '/config/conexao.php';

// Aceita apenas requisições POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: novo-chamado.php');
    exit;
}

// Validação do token CSRF
$token = $_POST['csrf_token'] ?? '';
if (!hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
    http_response_code(403);
    exit('Requisição inválida.');
}

$titulo    = trim($_POST['titulo'] ?? '');
$descricao = trim($_POST['descricao'] ?? '');

// Validação de entrada no servidor
$erro = null;
if ($titulo === '' || $descricao === '') {
    $erro = 'Preencha o título e a descrição.';
} elseif (mb_strlen($titulo) > 150) {
    $erro = 'O título deve ter no máximo 150 caracteres.';
}

if ($erro) {
    $_SESSION['erro_form'] = $erro;
    $_SESSION['dados_antigos'] = ['titulo' => $titulo, 'descricao' => $descricao];
    header('Location: novo-chamado.php');
    exit;
}

try {
    // Prepared statement com parâmetros nomeados: previne SQL Injection
    $stmt = $pdo->prepare(
        'INSERT INTO chamados (titulo, descricao) VALUES (:titulo, :descricao)'
    );
    $stmt->execute([
        ':titulo'    => $titulo,
        ':descricao' => $descricao,
    ]);

    $_SESSION['flash'] = ['tipo' => 'success', 'texto' => 'Chamado aberto com sucesso!'];
} catch (PDOException $e) {
    error_log('Erro ao salvar chamado: ' . $e->getMessage());
    $_SESSION['flash'] = ['tipo' => 'danger', 'texto' => 'Erro ao salvar o chamado. Tente novamente.'];
}

header('Location: index.php');
exit;
