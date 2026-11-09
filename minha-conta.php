<?php
require_once 'config/database.php';
require_once 'src/Auth.php';

Auth::requireLogin();
$pagina_atual = 'minha-conta.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Área do Treinador - PokéLar</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <header id="cabeca">
        <div id="cabeca-container">
            <a href="index.php" id="brand"><h1>PokéLar</h1></a>
            <nav id="nav">
                <a href="index.php" class="nav-link">Início</a>
                <a href="pokemon.php" class="nav-link">Pokémon Disponíveis</a>
                <a href="minha-conta.php" class="nav-link ativo">Minha Conta</a>
                <a href="alterar-senha.php" class="nav-link">Alterar Senha</a>
                <a href="logout.php" class="nav-link" style="background-color: #dc3545;">Sair</a>
            </nav>
        </div>
        <div id="linha">
            <button id="bola" type="button"><img src="img/botao_pokebola.png" alt="Pokébola" width="58" height="58"></button>
        </div>
    </header>

    <main class="container" style="padding: 40px 20px;">
        <section class="pagina-cabecalho" style="border-radius: var(--raio-borda); margin-bottom: 30px;">
            <h2>Bem-vindo(a), <?= htmlspecialchars($_SESSION['usuario_nome']) ?>!</h2>
            <p>Perfil: <strong><?= ucfirst(htmlspecialchars($_SESSION['usuario_perfil'])) ?></strong> | E-mail: <?= htmlspecialchars($_SESSION['usuario_email']) ?></p>
        </section>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px;">
            <div style="background: white; padding: 25px; border-radius: var(--raio-borda); box-shadow: var(--sombra-card);">
                <h3>🐾 Meus Pedidos de Adoção</h3>
                <p style="color: var(--texto-suave);">Você ainda não possui solicitações de adoção em andamento.</p>
                <a href="pokemon.php" class="btn-filtrar" style="display: inline-block; text-decoration: none; margin-top: 10px;">Ver Pokémon Disponíveis</a>
            </div>

            <div style="background: white; padding: 25px; border-radius: var(--raio-borda); box-shadow: var(--sombra-card);">
                <h3>🔒 Segurança da Conta</h3>
                <p style="color: var(--texto-suave);">Mantenha suas credenciais atualizadas regularmente.</p>
                <a href="alterar-senha.php" class="btn-filtrar" style="display: inline-block; text-decoration: none; margin-top: 10px; background: #6c757d;">Alterar Senha</a>
            </div>
        </div>
    </main>

</body>
</html>