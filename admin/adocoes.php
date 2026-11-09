<?php
require_once '../config/database.php';
require_once '../src/Auth.php';
require_once '../src/Csrf.php';
$pagina_atual = basename($_SERVER['PHP_SELF']);

Auth::requireAdmin();

// Busca todos os agendamentos com dados do cliente e do Pokémon
$stmt =$pdo->query("
    SELECT a.*, u.nome AS cliente_nome, u.email AS cliente_email, p.nome AS pokemon_nome, p.imagem
    FROM adocoes a
    JOIN usuarios u ON a.usuario_id = u.id
    JOIN pokemons p ON a.pokemon_id = p.id
    ORDER BY a.id DESC
");
$adocoes =$stmt->fetchAll();

$pagina_atual = 'adocoes.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Adoções - PokéLar Admin</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

    <!-- CABEÇALHO FIXO UNIFICADO (PAINEL ADMIN) -->
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


    <main class="container" style="padding: 40px 20px;">
        
        <section class="pagina-cabecalho" style="border-radius: var(--raio-borda); margin-bottom: 25px;">
            <span class="badge-tag">📋 Gestão de Visitas</span>
            <h2>Solicitações de Adoção</h2>
            <p>Acompanhe e atualize os agendamentos de visitas presenciais efetuados pelos treinadores.</p>
        </section>

        <?php if (isset($_GET['msg']) &&$_GET['msg'] === 'status_atualizado'): ?>
            <div style="background-color: #d4edda; color: #155724; padding: 12px; border-radius: 6px; margin-bottom: 20px; text-align: center; font-weight: bold;">
                ✅ Status do agendamento atualizado!
            </div>
        <?php endif; ?>

        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h3>Lista de Visitas Agendadas</h3>
            <a href="exportar-csv.php" class="btn-filtrar" style="text-decoration: none; background: #0284c7; padding: 10px 18px;">
                📥 Exportar Relatório CSV
            </a>
        </div>

        <div style="background: white; border-radius: var(--raio-borda); box-shadow: var(--sombra-card); overflow-x: auto; border: 1px solid var(--borda-suave);">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.9rem;">
                <thead>
                    <tr style="background-color: #f1f5f9; border-bottom: 2px solid var(--borda-suave);">
                        <th style="padding: 14px;">#ID</th>
                        <th style="padding: 14px;">Treinador (Cliente)</th>
                        <th style="padding: 14px;">Pokémon</th>
                        <th style="padding: 14px;">Data e Horário</th>
                        <th style="padding: 14px;">Observações</th>
                        <th style="padding: 14px;">Status do Agendamento</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($adocoes) > 0): ?>
                        <?php foreach ($adocoes as$sol): ?>
                            <tr style="border-bottom: 1px solid var(--borda-suave);">
                                <td style="padding: 14px; font-weight: bold;">#<?= $sol['id'] ?></td>
                                <td style="padding: 14px;">
                                    <strong><?= htmlspecialchars($sol['cliente_nome']) ?></strong><br>
                                    <small style="color: var(--texto-suave);"><?= htmlspecialchars($sol['cliente_email']) ?></small>
                                </td>
                                <td style="padding: 14px;">
                                    <div style="display: flex; align-items: center; gap: 8px;">
                                        <img src="../<?= htmlspecialchars($sol['imagem']) ?>" alt="" style="width: 35px; height: 35px; border-radius: 6px; object-fit: cover;">
                                        <strong><?= htmlspecialchars($sol['pokemon_nome']) ?></strong>
                                    </div>
                                </td>
                                <td style="padding: 14px;">
                                    📅 <?= date('d/m/Y', strtotime($sol['data_visita'])) ?><br>
                                    ⏰ <?= substr($sol['hora_visita'], 0, 5) ?>h
                                </td>
                                <td style="padding: 14px; max-width: 200px;">
                                    <small><?= !empty($sol['observacoes']) ? htmlspecialchars($sol['observacoes']) : '<em>Nenhuma</em>' ?></small>
                                </td>
                                <td style="padding: 14px;">
                                    <form action="atualizar-adocao.php" method="post" style="margin: 0;">
                                        <input type="hidden" name="csrf_token" value="<?= Csrf::generateToken() ?>">
                                        <input type="hidden" name="id" value="<?= $sol['id'] ?>">
                                        <select name="status" onchange="this.form.submit()" style="padding: 6px; border-radius: 6px; border: 1px solid #cbd5e1; font-weight: bold; cursor: pointer;">
                                            <option value="em_analise" <?= $sol['status'] === 'em_analise' ? 'selected' : '' ?>>🟡 Em Análise</option>
                                            <option value="confirmado" <?= $sol['status'] === 'confirmado' ? 'selected' : '' ?>>🟢 Visita Confirmada</option>
                                            <option value="concluido" <?= $sol['status'] === 'concluido' ? 'selected' : '' ?>>🎉 Adoção Concluída</option>
                                            <option value="cancelado" <?= $sol['status'] === 'cancelado' ? 'selected' : '' ?>>🔴 Cancelado</option>
                                        </select>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" style="padding: 20px; text-align: center; color: var(--texto-suave);">Nenhum agendamento registrado até o momento.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </main>

    <footer id="rodape">
        <div class="rodape-direitos">
            <p>&copy; 2026 PokéLar. Todos os direitos reservados.</p>
        </div>
    </footer>

</body>
</html>