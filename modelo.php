<?php
$pagina_atual = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Título da Página - PokéLar</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <!-- CABEÇALHO FIXO DO SITE -->
    <header id="cabeca">
        <div id="cabeca-container">
            <!-- Logo do PokéLar -->
            <a href="index.html" id="brand">
                <h1>PokéLar</h1>
            </a>

            <!-- Navegação Principal -->
            <nav id="nav" aria-label="Navegação Principal">
                <a href="index.php" class="nav-link <?= $pagina_atual === 'index.php' ? 'ativo' : '' ?>">Início</a>
                <a href="pokemon.php" class="nav-link <?= $pagina_atual === 'pokemon.php' ? 'ativo' : '' ?>">Pokémon Disponíveis</a>
                <a href="como-adotar.php" class="nav-link <?= $pagina_atual === 'como-adotar.php' ? 'ativo' : '' ?>">Como Adotar</a>
                <a href="sobre.php" class="nav-link <?= $pagina_atual === 'sobre.php' ? 'ativo' : '' ?>">Sobre Nós</a>

                <?php 
                require_once 'src/Auth.php';
                if (Auth::check()): 
                ?>
                    <?php if (Auth::isAdmin()): ?>
                        <a href="admin/index.php" class="nav-link nav-destaque">Painel Admin</a>
                    <?php endif; ?>
                    <a href="logout.php" class="nav-link" style="background-color: #dc3545; color: white;">Sair</a>
                <?php else: ?>
                    <a href="login.php" class="nav-link nav-destaque <?= $pagina_atual === 'login.php' ? 'ativo' : '' ?>">Login</a>
                <?php endif; ?>
            </nav>

            <!-- Contato Rápido -->
            <div id="contato-rapido">
                <a href="https://wa.me/5511941984860" target="_blank" rel="noopener noreferrer" title="WhatsApp">(11) 94198-4860</a>
            </div>
        </div>

        <!-- Linha Divisória com Pokébola Interativa -->
        <div id="linha">
            <button id="bola" onclick="alert('Bem-vindo ao PokéLar!')" title="Clique para uma surpresa" type="button">
                <img src="img/botao_pokebola.png" alt="Pokébola Interativa">
            </button>
        </div>
    </header>

    <!-- CONTEÚDO PRINCIPAL DA PÁGINA -->
    <main>
        <!-- Banner Interno Padrão de Título de Página -->
        <section class="pagina-cabecalho">
            <div class="container">
                <span class="badge-tag">🐾 PokéLar</span>
                <h2>Título da Sua Página Aqui</h2>
                <p>Escreva aqui um breve resumo ou introdução sobre o tema desta página.</p>
            </div>
        </section>

        <!-- Container para Conteúdo Geral (Trocado para div para evitar alerta semântico do W3C) -->
        <div class="pagina-conteudo">
            <div class="container">
                
                <!-- ==================================================== -->
                <!-- SEU CONTEÚDO ESPECÍFICO DESTA PÁGINA ENTRA AQUI      -->
                <!-- ==================================================== -->
                
                <p>Insira aqui os cards de Pokémon, textos institucionais ou formulários de adoção/login.</p>

            </div>
        </div>
    </main>

    <!-- RODAPÉ COMPLETO -->
    <footer id="rodape">
        <div class="rodape-conteudo">
            <section class="newsletter">
                <h3>Receba Notícias de Feiras</h3>
                <form action="#" method="post">
                    <label for="email-newsletter">Seu e-mail de treinador:</label>
                    <div class="campo-newsletter">
                        <input type="email" id="email-newsletter" name="email-newsletter" placeholder="exemplo@pokemail.com" required>
                        <button type="submit" class="botao">Cadastrar</button>
                    </div>
                </form>
            </section>

            <div class="rodape-contato">
                <h3>Canais de Contato</h3>
                <p>
                    <img src="img/whatsapp.png" alt="WhatsApp" class="icone-contato">
                    <strong>WhatsApp:</strong> <a href="https://wa.me/5511941984860" target="_blank" rel="noopener noreferrer">(11) 94198-4860</a>
                </p>
                <p>
                    <img src="img/telefone.png" alt="Telefone Fixo" class="icone-contato">
                    <strong>Telefone Fixo:</strong> (11) 3456-7890
                </p>
                <p>
                    <img src="img/instagram.png" alt="Instagram" class="icone-contato">
                    <strong>Instagram:</strong> <a href="https://instagram.com/pokelar_oficial" target="_blank" rel="noopener noreferrer">@pokelar_oficial</a>
                </p>
            </div>

            <div class="rodape-info">
                <h3>Centro de Resgate PokéLar</h3>
                <p>Rota 1, nº 151 - Kanto</p>
                <p>Visitações: Terça a Domingo, das 09h às 17h</p>
            </div>
        </div>

        <div class="rodape-direitos">
            <p>&copy; 2026 PokéLar. Todos os direitos reservados.</p>
            <p class="disclaimer">Projeto acadêmico desenvolvido para a disciplina de SCOM. Pokémon e suas marcas pertencem à Nintendo / Creatures Inc. / GAME FREAK inc.</p>
        </div>
    </footer>

</body>
</html>