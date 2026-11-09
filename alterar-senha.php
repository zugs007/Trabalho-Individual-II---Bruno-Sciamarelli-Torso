<?php
require_once 'config/database.php';
require_once 'src/Auth.php';
require_once 'src/Csrf.php';
require_once 'src/Logger.php';

Auth::requireLogin();

$erro = '';
$sucesso = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token          = $_POST['csrf_token'] ?? '';
    $senha_atual    = $_POST['senha_atual'] ?? '';
    $nova_senha     = $_POST['nova_senha'] ?? '';
    $confirmar_senha= $_POST['confirmar_senha'] ?? '';

    if (!Csrf::validateToken($token)) {
        $erro = 'Erro de validação CSRF.';
    } elseif (empty($senha_atual) || empty($nova_senha) || empty($confirmar_senha)) {
        $erro = 'Preencha todos os campos.';
    } elseif ($nova_senha !== $confirmar_senha) {
        $erro = 'A nova senha e a confirmação não coincidem.';
    } elseif (strlen($nova_senha) < 6) {
        $erro = 'A nova senha deve ter no mínimo 6 caracteres.';
    } else {
        // Busca a senha atual do usuário no banco
        $stmt = $pdo->prepare("SELECT senha FROM usuarios WHERE id = :id");
        $stmt->execute([':id' => $_SESSION['usuario_id']]);
        $usuario = $stmt->fetch();

        if ($usuario && password_verify($senha_atual, $usuario['senha'])) {
            $novoHash = password_hash($nova_senha, PASSWORD_DEFAULT);
            $update = $pdo->prepare("UPDATE usuarios SET senha = :senha WHERE id = :id");
            $update->execute([':senha' => $novoHash, ':id' => $_SESSION['usuario_id']]);

            Logger::log("Senha alterada com sucesso para o usuário ID: {$_SESSION['usuario_id']} ({$_SESSION['usuario_email']})", "INFO");
            $sucesso = 'Senha alterada com sucesso!';
        } else {
            $erro = 'A senha atual informada está incorreta.';
        }
    }
}
$pagina_atual = 'alterar-senha.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Senha - PokéLar</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <header id="cabeca">
        <div id="cabeca-container">
            <a href="index.php" id="brand"><h1>PokéLar</h1></a>
            <nav id="nav">
                <a href="index.php" class="nav-link">Início</a>
                <a href="pokemon.php" class="nav-link">Pokémon Disponíveis</a>
                <?php if (Auth::isAdmin()): ?>
                    <a href="admin/index.php" class="nav-link nav-destaque">Painel Admin</a>
                <?php endif; ?>
                <a href="alterar-senha.php" class="nav-link ativo">Alterar Senha</a>
                <a href="logout.php" class="nav-link" style="background-color: #dc3545;">Sair</a>
            </nav>
        </div>
        <div id="linha">
            <button id="bola" type="button"><img src="img/botao_pokebola.png" alt="Pokébola" width="58" height="58"></button>
        </div>
    </header>

    <main class="container py-5" style="max-width: 480px; margin: 40px auto;">
        <div class="painel-filtros" style="background: white; padding: 30px; border-radius: var(--raio-borda); box-shadow: var(--sombra-card);">
            <h2 style="text-align: center; margin-bottom: 20px;">Alterar Minha Senha</h2>

            <?php if ($erro): ?>
                <div style="background: #f8d7da; color: #721c24; padding: 10px; border-radius: 6px; margin-bottom: 15px; text-align: center;"><?= htmlspecialchars($erro) ?></div>
            <?php endif; ?>

            <?php if ($sucesso): ?>
                <div style="background: #d4edda; color: #155724; padding: 10px; border-radius: 6px; margin-bottom: 15px; text-align: center;"><?= htmlspecialchars($sucesso) ?></div>
            <?php endif; ?>

            <form action="alterar-senha.php" method="post" style="display: flex; flex-direction: column; gap: 15px;">
                <input type="hidden" name="csrf_token" value="<?= Csrf::generateToken() ?>">

                <div class="campo-filtro">
                    <label for="senha_atual">Senha Atual *</label>
                    <input type="password" id="senha_atual" name="senha_atual" required>
                </div>

                <div class="campo-filtro">
                    <label for="nova_senha">Nova Senha * (mínimo 6 caracteres)</label>
                    <input type="password" id="nova_senha" name="nova_senha" required>
                </div>

                <div class="campo-filtro">
                    <label for="confirmar_senha">Confirmar Nova Senha *</label>
                    <input type="password" id="confirmar_senha" name="confirmar_senha" required>
                </div>

                <button type="submit" class="btn-filtrar" style="margin-top: 10px;">Atualizar Senha</button>
            </form>
        </div>
    </main>

</body>
</html>