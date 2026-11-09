<?php
require_once '../config/database.php';
require_once '../src/Auth.php';

// Exige perfil de Administrador
Auth::requireAdmin();

// Busca todos os Pokémon cadastrados
$stmt = $pdo->query("SELECT * FROM pokemons ORDER BY id DESC");
$pokemons = $stmt->fetchAll();

// Descobre a página atual para manter a classe 'ativo' no menu
$pagina_atual = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo - PokéLar</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

    <!-- CABEÇALHO FIXO COM A POKÉBOLA -->
    <header id="cabeca">
        <div id="cabeca-container">
            <a href="../index.php" id="brand">
                <h1>PokéLar</h1>
            </a>
            <nav id="nav" aria-label="Navegação Principal">
                <a href="../index.php" class="nav-link">Início</a>
                <a href="../pokemon.php" class="nav-link">Pokémon Disponíveis</a>
                <a href="../como-adotar.php" class="nav-link">Como Adotar</a>
                <a href="../sobre.php" class="nav-link">Sobre Nós</a>
                <a href="index.php" class="nav-link nav-destaque ativo">Painel Admin</a>
                <a href="../logout.php" class="nav-link" style="background-color: #dc3545;">Sair</a>
            </nav>
            <div id="contato-rapido">
                <a href="https://wa.me/5511941984860" target="_blank" rel="noopener noreferrer" title="Falar no WhatsApp">(11) 94198-4860</a>
            </div>
        </div>

        <!-- LINHA PRETA COM A POKÉBOLA INTERATIVA -->
        <div id="linha">
            <button id="bola" onclick="alert('Área Administrativa do PokéLar!')" title="Clique para uma surpresa" type="button">
                <img src="../img/botao_pokebola.png" alt="Pokébola Interativa" width="58" height="58">
            </button>
        </div>
    </header>

    <!-- CONTEÚDO PRINCIPAL -->
    <main>
        <!-- BANNER PADRÃO DO SITE -->
        <section class="pagina-cabecalho">
            <div class="container">
                <span class="badge-tag">⚡ Gestão do Sistema</span>
                <h2>Painel Administrativo</h2>
                <p>Gerencie o cadastro de Pokémon resgatados, atualize status e administre o catálogo do PokéLar.</p>
            </div>
        </section>

        <!-- TABELA DE GESTÃO -->
        <section class="pagina-conteudo">
            <div class="container">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; flex-wrap: wrap; gap: 15px;">
                    <div>
                        <h3 style="margin: 0; font-size: 1.5rem; color: var(--texto-escuro);">Lista de Pokémon Cadastrados</h3>
                        <p style="margin: 5px 0 0 0; color: var(--texto-suave);">
                            Sessão ativa: <strong><?= htmlspecialchars($_SESSION['usuario_nome']) ?></strong> (<?= htmlspecialchars($_SESSION['usuario_perfil']) ?>)
                        </p>
                    </div>
                    <a href="criar.php" class="btn-filtrar" style="text-decoration: none; padding: 12px 24px; font-weight: bold;">+ Cadastrar Novo Pokémon</a>
                </div>

                <div style="background: var(--fundo-card); border-radius: var(--raio-borda); box-shadow: var(--sombra-card); overflow-x: auto; border: 1px solid var(--borda-suave);">
                    <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.95rem;">
                        <thead>
                            <tr style="background-color: #f1f5f9; border-bottom: 2px solid var(--borda-suave);">
                                <th style="padding: 16px;">ID</th>
                                <th style="padding: 16px;">Nome</th>
                                <th style="padding: 16px;">Tipo Primário</th>
                                <th style="padding: 16px;">Porte</th>
                                <th style="padding: 16px;">Status</th>
                                <th style="padding: 16px; text-align: center;">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pokemons as $poke): ?>
                                <tr style="border-bottom: 1px solid var(--borda-suave); transition: background-color 0.2s;">
                                    <td style="padding: 16px; font-weight: bold; color: var(--texto-suave);">#<?= $poke['id'] ?></td>
                                    <td style="padding: 16px;">
                                        <div style="display: flex; align-items: center; gap: 12px;">
                                            <img src="../<?= htmlspecialchars($poke['imagem']) ?>" alt="" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 1px solid #ddd;">
                                            <strong><?= htmlspecialchars($poke['nome']) ?></strong>
                                        </div>
                                    </td>
                                    <td style="padding: 16px;">
                                        <span class="tag-tipo tipo-<?= htmlspecialchars($poke['tipo_primario']) ?>">
                                            <?= ucfirst(htmlspecialchars($poke['tipo_primario'])) ?>
                                        </span>
                                    </td>
                                    <td style="padding: 16px; text-transform: capitalize;"><?= htmlspecialchars($poke['porte']) ?></td>
                                    <td style="padding: 16px;">
                                        <?php if ($poke['status'] === 'disponivel'): ?>
                                            <span class="badge-status disponivel">Disponível</span>
                                        <?php else: ?>
                                            <span class="badge-status em-processo">Em Adoção</span>
                                        <?php endif; ?>
                                    </td>
                                    <td style="padding: 16px; text-align: center;">
                                        <a href="editar.php?id=<?= $poke['id'] ?>" style="color: #0284c7; text-decoration: none; font-weight: bold; margin-right: 15px;">Editar</a>
                                        <a href="deletar.php?id=<?= $poke['id'] ?>" onclick="return confirm('Deseja realmente remover <?= htmlspecialchars($poke['nome']) ?>?');" style="color: #e53e3e; text-decoration: none; font-weight: bold;">Excluir</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
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
                        <button type="submit">Cadastrar</button>
                    </div>
                </form>
            </section>
            <div class="rodape-contato">
                <h3>Canais de Contato</h3>
                <p><strong>WhatsApp:</strong> <a href="https://wa.me/5511941984860" target="_blank" rel="noopener noreferrer">(11) 94198-4860</a></p>
                <p><strong>Telefone Fixo:</strong> (11) 3456-7890</p>
                <p><strong>Instagram:</strong> <a href="https://instagram.com/pokelar_oficial" target="_blank" rel="noopener noreferrer">@pokelar_oficial</a></p>
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