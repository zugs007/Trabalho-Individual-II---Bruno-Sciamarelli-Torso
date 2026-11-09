<?php
require_once 'config/database.php';
require_once 'src/Csrf.php';
require_once 'src/Auth.php';
require_once 'src/Logger.php';

$erro = '';
$sucesso = '';

// Se já estiver logado, redireciona para a página principal
if (Auth::check()) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token         = $_POST['csrf_token'] ?? '';
    $nome          = trim($_POST['nome'] ?? '');
    $email         = trim($_POST['email'] ?? '');
    $senha         = $_POST['senha'] ?? '';
    $confirmar     = $_POST['confirmar_senha'] ?? '';
    $perfil        = trim($_POST['perfil'] ?? 'cliente'); // Padrão: cliente

    // Apenas admins logados poderiam criar outros admins publicamente, senão força 'cliente'
    if ($perfil !== 'cliente' && !Auth::isAdmin()) {
        $perfil = 'cliente';
    }

    if (!Csrf::validateToken($token)) {
        $erro = 'Erro de validação CSRF. Tente novamente.';
    } elseif (empty($nome) || empty($email) || empty($senha) || empty($confirmar)) {
        $erro = 'Por favor, preencha todos os campos obrigatórios.';
    } elseif ($senha !== $confirmar) {
        $erro = 'As senhas digitadas não coincidem.';
    } elseif (strlen($senha) < 6) {
        $erro = 'A senha deve ter pelo menos 6 caracteres.';
    } else {
        // Verifica se o e-mail já existe no banco
        $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = :email");
        $stmt->execute([':email' => $email]);
        
        if ($stmt->fetch()) {
            $erro = 'Este e-mail já está cadastrado no sistema.';
        } else {
            // Criptografa a senha com Bcrypt
            $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

            $sql = "INSERT INTO usuarios (nome, email, senha, perfil) VALUES (:nome, :email, :senha, :perfil)";
            $insert = $pdo->prepare($sql);
            
            if ($insert->execute([':nome' => $nome, ':email' => $email, ':senha' => $senhaHash, ':perfil' => $perfil])) {
                Logger::log("Novo cadastro efetuado: {$email} (Perfil: {$perfil})", "INFO");
                header('Location: login.php?msg=cadastrado');
                exit;
            } else {
                $erro = 'Erro ao realizar o cadastro. Tente novamente.';
            }
        }
    }
}
$pagina_atual = 'cadastro.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Treinador - PokéLar</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <header id="cabeca">
        <div id="cabeca-container">
            <a href="index.php" id="brand"><h1>PokéLar</h1></a>
            <nav id="nav">
                <a href="index.php" class="nav-link">Início</a>
                <a href="pokemon.php" class="nav-link">Pokémon Disponíveis</a>
                <a href="como-adotar.php" class="nav-link">Como Adotar</a>
                <a href="sobre.php" class="nav-link">Sobre Nós</a>
                <a href="login.php" class="nav-link nav-destaque">Login</a>
            </nav>
        </div>
        <div id="linha">
            <button id="bola" type="button"><img src="img/botao_pokebola.png" alt="Pokébola" width="58" height="58"></button>
        </div>
    </header>

    <main>
        <section class="pagina-cabecalho">
            <div class="container">
                <span class="badge-tag">📝 Novo Treinador</span>
                <h2>Crie sua Conta</h2>
                <p>Cadastre-se para solicitar adoções e acompanhar seus Pokémon favoritos.</p>
            </div>
        </section>

        <section class="pagina-conteudo">
            <div class="container container-login">
                <div class="card-form-login">
                    <div class="form-cabecalho">
                        <h3>Formulário de Cadastro</h3>
                        <p>Preencha os dados abaixo para criar seu perfil.</p>
                    </div>

                    <?php if (!empty($erro)): ?>
                        <div style="background-color: #f8d7da; color: #721c24; padding: 12px; border-radius: 6px; margin-bottom: 20px; text-align: center;">
                            <?= htmlspecialchars($erro) ?>
                        </div>
                    <?php endif; ?>

                    <form action="cadastro.php" method="post" class="form-login">
                        <input type="hidden" name="csrf_token" value="<?= Csrf::generateToken() ?>">

                        <div class="campo-grupo">
                            <label for="nome">Nome Completo *</label>
                            <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($_POST['nome'] ?? '') ?>" required placeholder="Ex: Ash Ketchum">
                        </div>

                        <div class="campo-grupo">
                            <label for="email">E-mail *</label>
                            <input type="email" id="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required placeholder="seu@email.com">
                        </div>

                        <div class="campo-grupo">
                            <label for="senha">Senha * (mínimo 6 caracteres)</label>
                            <input type="password" id="senha" name="senha" required placeholder="••••••••">
                        </div>

                        <div class="campo-grupo">
                            <label for="confirmar_senha">Confirmar Senha *</label>
                            <input type="password" id="confirmar_senha" name="confirmar_senha" required placeholder="••••••••">
                        </div>

                        <button type="submit" class="btn-login-submeter">Criar Conta</button>
                    </form>

                    <div class="form-rodape-opcao">
                        <p>Já possui uma conta? <a href="login.php" class="link-destaque">Faça Login</a></p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer id="rodape">
        <div class="rodape-direitos">
            <p>&copy; 2026 PokéLar. Todos os direitos reservados.</p>
        </div>
    </footer>

</body>
</html>