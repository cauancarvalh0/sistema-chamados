<?php
session_start();
require_once __DIR__ . '/config/conexao.php';

// Token CSRF para proteger o formulário de alteração de status
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Mensagem de retorno (flash) exibida uma única vez
$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$chamados = [];
$erro = null;

try {
    $stmt = $pdo->query(
        'SELECT id, titulo, descricao, status, data_criacao
           FROM chamados
          ORDER BY data_criacao DESC, id DESC'
    );
    $chamados = $stmt->fetchAll();
} catch (PDOException $e) {
    error_log('Erro ao listar chamados: ' . $e->getMessage());
    $erro = 'Não foi possível carregar os chamados no momento.';
}

// Mapeamento de status para classes de badge do Bootstrap
$badges = [
    'Aberto'       => 'bg-danger',
    'Em Andamento' => 'bg-warning text-dark',
    'Resolvido'    => 'bg-success',
];
$statusDisponiveis = array_keys($badges);

// Contadores para os cards de resumo
$totais = array_fill_keys($statusDisponiveis, 0);
foreach ($chamados as $c) {
    $totais[$c['status']]++;
}

// Função auxiliar de escape para evitar XSS na saída
function e(string $valor): string
{
    return htmlspecialchars($valor, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HelpDesk | Controle de Chamados</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-dark mb-4">
    <div class="container">
        <span class="navbar-brand fw-bold">HelpDesk</span>
        <a href="novo-chamado.php" class="btn btn-primary btn-sm">+ Novo chamado</a>
    </div>
</nav>

<main class="container pb-5">

    <?php if ($flash): ?>
        <div class="alert alert-<?= e($flash['tipo']) ?> alert-dismissible fade show" role="alert">
            <?= e($flash['texto']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
        </div>
    <?php endif; ?>

    <?php if ($erro): ?>
        <div class="alert alert-danger"><?= e($erro) ?></div>
    <?php endif; ?>

    <!-- Cards de resumo -->
    <div class="row g-3 mb-4">
        <?php foreach ($totais as $nome => $qtd): ?>
            <div class="col-12 col-md-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <span class="text-muted"><?= e($nome) ?></span>
                        <span class="badge <?= $badges[$nome] ?> fs-6"><?= $qtd ?></span>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white fw-semibold">Chamados cadastrados</div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Título</th>
                        <th>Descrição</th>
                        <th>Status</th>
                        <th>Criado em</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (empty($chamados)): ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">Nenhum chamado cadastrado.</td>
                    </tr>
                <?php endif; ?>

                <?php foreach ($chamados as $c): ?>
                    <tr>
                        <td><?= (int) $c['id'] ?></td>
                        <td class="fw-semibold"><?= e($c['titulo']) ?></td>
                        <td class="text-muted"><?= e(mb_strimwidth($c['descricao'], 0, 80, '...')) ?></td>
                        <td><span class="badge <?= $badges[$c['status']] ?>"><?= e($c['status']) ?></span></td>
                        <td><?= date('d/m/Y H:i', strtotime($c['data_criacao'])) ?></td>
                        <td class="text-end">
                            <!-- Cada opção envia um POST independente para atualizar-status.php -->
                            <form action="atualizar-status.php" method="POST" class="d-inline">
                                <input type="hidden" name="csrf_token" value="<?= e($_SESSION['csrf_token']) ?>">
                                <input type="hidden" name="id" value="<?= (int) $c['id'] ?>">
                                <div class="dropdown">
                                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                        Alterar status
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <?php foreach ($statusDisponiveis as $s): ?>
                                            <li>
                                                <button type="submit" name="status" value="<?= e($s) ?>"
                                                        class="dropdown-item" <?= $s === $c['status'] ? 'disabled' : '' ?>>
                                                    <?= e($s) ?>
                                                </button>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
