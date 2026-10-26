<?php
session_start();

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Recupera erro de validação e dados antigos (se houver) para repopular o formulário
$erro = $_SESSION['erro_form'] ?? null;
$antigo = $_SESSION['dados_antigos'] ?? ['titulo' => '', 'descricao' => ''];
unset($_SESSION['erro_form'], $_SESSION['dados_antigos']);

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
    <title>Novo Chamado | HelpDesk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-dark mb-4">
    <div class="container">
        <a href="index.php" class="navbar-brand fw-bold">HelpDesk</a>
    </div>
</nav>

<main class="container pb-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white fw-semibold">Abrir novo chamado</div>
                <div class="card-body">

                    <?php if ($erro): ?>
                        <div class="alert alert-danger"><?= e($erro) ?></div>
                    <?php endif; ?>

                    <form action="salvar-chamado.php" method="POST" novalidate>
                        <input type="hidden" name="csrf_token" value="<?= e($_SESSION['csrf_token']) ?>">

                        <div class="mb-3">
                            <label for="titulo" class="form-label">Título</label>
                            <input type="text" class="form-control" id="titulo" name="titulo"
                                   maxlength="150" required value="<?= e($antigo['titulo']) ?>"
                                   placeholder="Ex.: Impressora sem comunicação">
                        </div>

                        <div class="mb-3">
                            <label for="descricao" class="form-label">Descrição do problema</label>
                            <textarea class="form-control" id="descricao" name="descricao" rows="5"
                                      required placeholder="Descreva o problema com o máximo de detalhes"><?= e($antigo['descricao']) ?></textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="index.php" class="btn btn-outline-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Salvar chamado</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

</body>
</html>
