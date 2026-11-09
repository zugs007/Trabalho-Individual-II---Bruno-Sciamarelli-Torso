<?php
require_once '../config/database.php';
require_once '../src/Auth.php';
require_once '../src/Csrf.php';

// Exige perfil de Administrador
Auth::requireAdmin();

// Busca todos os Pokémon cadastrados
$stmt = $pdo->query("SELECT * FROM pokemons ORDER BY id DESC");
$pokemons = $stmt->fetchAll();

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

    <!-- CABEÇALHO FIXO -->
<header id="cabeca">
    <div id="cabeca-container">
        <a href="../index.php" id="brand">
            <h1>PokéLar</h1>
        </a>

        <!-- NAVEGAÇÃO COMPLETA DO ADMIN -->
        <nav id="nav" aria-label="Navegação Principal">
            <!-- Links do Site Público (Usam ../ para voltar à raiz) -->
            <a href="../index.php" class="nav-link">Início</a>
            <a href="../pokemon.php" class="nav-link">Pokémon Disponíveis</a>
            <a href="../como-adotar.php" class="nav-link">Como Adotar</a>
            <a href="../sobre.php" class="nav-link">Sobre Nós</a>

            <!-- Ferramentas do Admin (Dentro da pasta admin/) -->
            <a href="index.php" class="nav-link <?= $pagina_atual === 'index.php' ? 'ativo' : '' ?> nav-destaque">
                Painel Admin
            </a>

            <!-- Botão de Sair -->
            <a href="../logout.php" class="nav-link" style="background-color: #dc3545; color: white;">Sair</a>
        </nav>

        <div id="contato-rapido">
            <a href="https://wa.me/5511941984860" target="_blank" rel="noopener noreferrer" title="Falar no WhatsApp">(11) 94198-4860</a>
        </div>
    </div>

    <div id="linha">
        <button id="bola" onclick="alert('Área Administrativa PokéLar')" title="Clique para uma surpresa" type="button">
            <img src="../img/botao_pokebola.png" alt="Pokébola Interativa" width="58" height="58">
        </button>
    </div>
</header>

    <!-- CONTEÚDO PRINCIPAL -->
    <main>
        <section class="pagina-cabecalho">
            <div class="container">
                <span class="badge-tag">⚡ Gestão do Sistema</span>
                <h2>Painel Administrativo</h2>
                <p>Gerencie o cadastro de Pokémon resgatados, altere status em tempo real e administre o catálogo do PokéLar.</p>
            </div>
        </section>

        <section class="pagina-conteudo">
            <div class="container">

                <!-- MENSAGENS DE FEEDBACK -->
                <?php if (isset($_GET['msg']) && $_GET['msg'] === 'status_atualizado'): ?>
                    <div style="background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; padding: 12px 18px; border-radius: 8px; margin-bottom: 20px; font-weight: bold;">
                        ✅ Status do Pokémon atualizado com sucesso!
                    </div>
                <?php endif; ?>

                <?php if (isset($_GET['msg']) && $_GET['msg'] === 'cadastrado'): ?>
                    <div style="background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; padding: 12px 18px; border-radius: 8px; margin-bottom: 20px; font-weight: bold;">
                        🎉 Novo Pokémon cadastrado com sucesso!
                    </div>
                <?php endif; ?>

                <?php if (isset($_GET['msg']) && $_GET['msg'] === 'removido'): ?>
                    <div style="background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; padding: 12px 18px; border-radius: 8px; margin-bottom: 20px; font-weight: bold;">
                        🗑️ Registro de Pokémon removido.
                    </div>
                <?php endif; ?>

                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; flex-wrap: wrap; gap: 15px;">
                    <div>
                        <h3 style="margin: 0; font-size: 1.5rem; color: var(--texto-escuro);">Catálogo de Resgatados</h3>
                        <p style="margin: 5px 0 0 0; color: var(--texto-suave);">
                            Sessão ativa: <strong><?= htmlspecialchars($_SESSION['usuario_nome']) ?></strong> (<?= htmlspecialchars($_SESSION['usuario_perfil']) ?>)
                        </p>
                    </div>
                    
                    <!-- BOTÕES DE AÇÃO DO ADMIN -->
                    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                        <a href="adocoes.php" class="btn-filtrar" style="text-decoration: none; padding: 12px 20px; background: #0284c7; font-weight: bold;">
                            📋 Gestão de Agendamentos
                        </a>
                        <a href="create.php" class="btn-filtrar" style="text-decoration: none; padding: 12px 20px; font-weight: bold;">
                            + Cadastrar Novo Pokémon
                        </a>
                    </div>
                </div>

                <div style="background: var(--fundo-card); border-radius: var(--raio-borda); box-shadow: var(--sombra-card); overflow-x: auto; border: 1px solid var(--borda-suave);">
                    <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.95rem;">
                        <thead>
                            <tr style="background-color: #f1f5f9; border-bottom: 2px solid var(--borda-suave);">
                                <th style="padding: 16px;">ID</th>
                                <th style="padding: 16px;">Pokémon</th>
                                <th style="padding: 16px;">Tipo Primário</th>
                                <th style="padding: 16px;">Porte</th>
                                <th style="padding: 16px;">Status (Atualização Rápida)</th>
                                <th style="padding: 16px; text-align: center;">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pokemons as $poke): ?>
                                <tr style="border-bottom: 1px solid var(--borda-suave); transition: background-color 0.2s;">
                                    <td style="padding: 16px; font-weight: bold; color: var(--texto-suave);">#<?= $poke['id'] ?></td>
                                    <td style="padding: 16px;">
                                        <div style="display: flex; align-items: center; gap: 12px;">
                                            <img src="../<?= htmlspecialchars($poke['imagem']) ?>" alt="" style="width: 42px; height: 42px; border-radius: 50%; object-fit: cover; border: 1px solid #ddd;">
                                            <strong><?= htmlspecialchars($poke['nome']) ?></strong>
                                        </div>
                                    </td>
                                    <td style="padding: 16px;">
                                        <span class="tag-tipo tipo-<?= htmlspecialchars($poke['tipo_primario']) ?>">
                                            <?= ucfirst(htmlspecialchars($poke['tipo_primario'])) ?>
                                        </span>
                                    </td>
                                    <td style="padding: 16px; text-transform: capitalize;"><?= htmlspecialchars($poke['porte']) ?></td>
                                    
                                    <!-- COLUNA DE STATUS COM FORMULÁRIO RÁPIDO -->
                                    <td style="padding: 16px;">
                                        <form action="atualizar-status.php" method="post" style="display: flex; align-items: center; margin: 0;">
                                            <input type="hidden" name="csrf_token" value="<?= Csrf::generateToken() ?>">
                                            <input type="hidden" name="id" value="<?= $poke['id'] ?>">
                                            <select 
                                                name="status" 
                                                onchange="this.form.submit()" 
                                                style="padding: 6px 12px; border-radius: 20px; border: 1px solid #cbd5e1; font-weight: bold; font-size: 0.85rem; cursor: pointer; outline: none; background: #fff;"
                                            >
                                                <option value="disponivel" <?= $poke['status'] === 'disponivel' ? 'selected' : '' ?>>🟢 Disponível</option>
                                                <option value="em-processo" <?= ($poke['status'] === 'em-processo' || $poke['status'] === 'em_analise') ? 'selected' : '' ?>>🟡 Em Análise</option>
                                                <option value="adotado" <?= $poke['status'] === 'adotado' ? 'selected' : '' ?>>🔴 Adotado</option>
                                            </select>
                                        </form>
                                    </td>

                                    <td style="padding: 16px; text-align: center;">
                                        <a href="update.php?id=<?= $poke['id'] ?>" style="color: #0284c7; text-decoration: none; font-weight: bold; margin-right: 15px;">Editar</a>
                                        <a href="delete.php?id=<?= $poke['id'] ?>" onclick="return confirm('Deseja realmente remover <?= htmlspecialchars($poke['nome']) ?>?');" style="color: #e53e3e; text-decoration: none; font-weight: bold;">Excluir</a>
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