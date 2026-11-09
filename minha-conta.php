<?php
require_once 'config/database.php';
require_once 'src/Auth.php';

Auth::requireLogin();

// Consulta todas as solicitações de adoção efetuadas pelo usuário logado
$stmt = $pdo->prepare("
    SELECT a.*, p.nome AS pokemon_nome, p.imagem, p.tipo_primario, p.porte
    FROM adocoes a
    JOIN pokemons p ON a.pokemon_id = p.id
    WHERE a.usuario_id = :uid
    ORDER BY a.id DESC
");
$stmt->execute([':uid' => $_SESSION['usuario_id']]);
$minhas_solicitacoes = $stmt->fetchAll();

$pagina_atual = basename($_SERVER['PHP_SELF']);
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
                <a href="como-adotar.php" class="nav-link">Como Adotar</a>
                <a href="sobre.php" class="nav-link">Sobre Nós</a>
                <a href="minha-conta.php" class="nav-link ativo">Minha Conta</a>
                <a href="logout.php" class="nav-link" style="background-color: #dc3545; color: white;">Sair</a>
            </nav>
        </div>
        <div id="linha">
            <button id="bola" type="button"><img src="img/botao_pokebola.png" alt="Pokébola" width="58" height="58"></button>
        </div>
    </header>

    <main class="container" style="padding: 40px 20px;">

        <?php if (isset($_GET['msg']) && $_GET['msg'] === 'agendado_com_sucesso'): ?>
            <div style="background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; padding: 15px; border-radius: 8px; margin-bottom: 25px; text-align: center; font-weight: bold;">
                🎉 Agendamento realizado com sucesso! Sua visita para conhecer o(a) <?= htmlspecialchars($_GET['pokemon'] ?? '') ?> foi confirmada.
            </div>
        <?php endif; ?>

        <section class="pagina-cabecalho" style="border-radius: var(--raio-borda); margin-bottom: 30px;">
            <h2>Painel do Treinador: <?= htmlspecialchars($_SESSION['usuario_nome']) ?></h2>
            <p>E-mail: <strong><?= htmlspecialchars($_SESSION['usuario_email']) ?></strong> | Perfil: <?= ucfirst(htmlspecialchars($_SESSION['usuario_perfil'])) ?></p>
        </section>

        <!-- SEÇÃO: MEUS PEDIDOS DE ADOÇÃO -->
        <div style="background: white; padding: 25px; border-radius: var(--raio-borda); box-shadow: var(--sombra-card); margin-bottom: 30px;">
            <h3 style="margin-top: 0; color: var(--texto-escuro); border-bottom: 2px solid var(--borda-suave); padding-bottom: 10px;">
                🐾 Meus Pedidos de Adoção & Agendamentos
            </h3>

            <?php if (count($minhas_solicitacoes) > 0): ?>
                <div style="display: flex; flex-direction: column; gap: 15px; margin-top: 15px;">
                    <?php foreach ($minhas_solicitacoes as $sol): ?>
                        <div style="display: flex; align-items: center; justify-content: space-between; border: 1px solid var(--borda-suave); padding: 15px; border-radius: 8px; flex-wrap: wrap; gap: 15px;">
                            <div style="display: flex; align-items: center; gap: 15px;">
                                <img src="<?= htmlspecialchars($sol['imagem']) ?>" alt="" style="width: 60px; height: 60px; border-radius: 8px; object-fit: cover;">
                                <div>
                                    <h4 style="margin: 0; font-size: 1.1rem; color: var(--texto-escuro);"><?= htmlspecialchars($sol['pokemon_nome']) ?></h4>
                                    <p style="margin: 3px 0 0 0; color: var(--texto-suave); font-size: 0.85rem;">
                                        Visita agendada para: <strong><?= date('d/m/Y', strtotime($sol['data_visita'])) ?></strong> às <strong><?= substr($sol['hora_visita'], 0, 5) ?>h</strong>
                                    </p>
                                </div>
                            </div>
                            <div>
                                <?php if ($sol['status'] === 'em_analise'): ?>
                                    <span class="badge-status em-processo" style="padding: 6px 12px; font-size: 0.85rem;">Em Análise</span>
                                <?php elseif ($sol['status'] === 'confirmado'): ?>
                                    <span class="badge-status disponivel" style="padding: 6px 12px; font-size: 0.85rem;">Visita Confirmada</span>
                                <?php else: ?>
                                    <span style="background: #6c757d; color: white; padding: 6px 12px; border-radius: 20px; font-size: 0.85rem; font-weight: bold;">Adoção Concluída</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p style="color: var(--texto-suave); margin-top: 15px;">Você ainda não possui solicitações de adoção ou visitas agendadas.</p>
                <a href="pokemon.php" class="btn-filtrar" style="display: inline-block; text-decoration: none; margin-top: 10px;">Explorar Pokémon Disponíveis</a>
            <?php endif; ?>
        </div>

        <div style="background: white; padding: 25px; border-radius: var(--raio-borda); box-shadow: var(--sombra-card);">
            <h3 style="margin-top: 0;">🔒 Configurações de Segurança</h3>
            <p style="color: var(--texto-suave);">Mantenha sua senha sempre atualizada.</p>
            <a href="alterar-senha.php" class="btn-filtrar" style="display: inline-block; text-decoration: none; background: #6c757d;">Alterar Minha Senha</a>
        </div>

    </main>

    <footer id="rodape">
        <div class="rodape-direitos">
            <p>&copy; 2026 PokéLar. Todos os direitos reservados.</p>
        </div>
    </footer>

</body>
</html>