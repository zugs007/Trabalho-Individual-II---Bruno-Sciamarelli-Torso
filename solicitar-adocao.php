<?php
require_once 'config/database.php';
require_once 'src/Auth.php';
require_once 'src/Csrf.php';
require_once 'src/Logger.php';

Auth::requireLogin();

$pokemon_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$erro = '';

// Busca os dados do Pokémon escolhido
$stmt = $pdo->prepare("SELECT * FROM pokemons WHERE id = :id AND status = 'disponivel'");
$stmt->execute([':id' => $pokemon_id]);
$pokemon = $stmt->fetch();

if (!$pokemon) {
    header('Location: pokemon.php?erro=nao_disponivel');
    exit;
}

// Processa o formulário de agendamento
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token        = $_POST['csrf_token'] ?? '';
    $data_visita  = $_POST['data_visita'] ?? '';
    $hora_visita  = $_POST['hora_visita'] ?? '';
    $observacoes  = trim($_POST['observacoes'] ?? '');

    if (!Csrf::validateToken($token)) {
        $erro = 'Validação CSRF falhou. Tente novamente.';
    } elseif (empty($data_visita) || empty($hora_visita)) {
        $erro = 'Por favor, selecione a data e o horário para a visita.';
    } else {
        try {
            // Insere o agendamento no banco de dados
            $sql = "INSERT INTO adocoes (usuario_id, pokemon_id, data_visita, hora_visita, observacoes, status) 
                    VALUES (:uid, :pid, :data, :hora, :obs, 'em_analise')";
            $insert = $pdo->prepare($sql);
            $insert->execute([
                ':uid'  => $_SESSION['usuario_id'],
                ':pid'  => $pokemon['id'],
                ':data' => $data_visita,
                ':hora' => $hora_visita,
                ':obs'  => $observacoes
            ]);

            // Atualiza o status do Pokémon para 'em-processo'
            $update = $pdo->prepare("UPDATE pokemons SET status = 'em-processo' WHERE id = :id");
            $update->execute([':id' => $pokemon['id']]);

            Logger::log(
                "Agendamento de visita efetuado: Pokémon {$pokemon['nome']} (#{$pokemon['id']}) reservado por {$_SESSION['usuario_email']} para {$data_visita} às {$hora_visita}", 
                "INFO"
            );

            header('Location: minha-conta.php?msg=agendado_com_sucesso&pokemon=' . urlencode($pokemon['nome']));
            exit;
        } catch (PDOException $e) {
            Logger::log("Erro no agendamento: " . $e->getMessage(), "ERROR");
            $erro = "Erro ao registrar o agendamento. Tente novamente.";
        }
    }
}

$pagina_atual = 'solicitar-adocao.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendar Visita de Adoção - PokéLar</title>
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
                <a href="minha-conta.php" class="nav-link">Minha Conta</a>
                <a href="logout.php" class="nav-link" style="background-color: #dc3545; color: white;">Sair</a>
            </nav>
        </div>
        <div id="linha">
            <button id="bola" type="button"><img src="img/botao_pokebola.png" alt="Pokébola" width="58" height="58"></button>
        </div>
    </header>

    <main class="container py-5" style="max-width: 650px; margin: 40px auto;">
        
        <section class="pagina-cabecalho" style="border-radius: var(--raio-borda); text-align: center; margin-bottom: 25px;">
            <span class="badge-tag">🗓️ Agendamento de Visita</span>
            <h2>Solicitação de Adoção: <?= htmlspecialchars($pokemon['nome']) ?></h2>
            <p>Escolha o melhor dia e horário para conhecer o seu novo companheiro no Centro de Resgate PokéLar.</p>
        </section>

        <div class="painel-filtros" style="background: white; padding: 30px; border-radius: var(--raio-borda); box-shadow: var(--sombra-card);">
            
            <div style="display: flex; align-items: center; gap: 20px; padding-bottom: 20px; border-bottom: 1px solid var(--borda-suave); margin-bottom: 20px;">
                <img src="<?= htmlspecialchars($pokemon['imagem']) ?>" alt="" style="width: 90px; height: 90px; border-radius: 12px; object-fit: cover; border: 2px solid var(--verde-friendball);">
                <div>
                    <h3 style="margin: 0; color: var(--texto-escuro);"><?= htmlspecialchars($pokemon['nome']) ?></h3>
                    <p style="margin: 4px 0 0 0; color: var(--texto-suave); font-size: 0.9rem;">
                        Porte: <?= ucfirst(htmlspecialchars($pokemon['porte'])) ?> | Idade: <?= htmlspecialchars($pokemon['idade']) ?>
                    </p>
                    <span class="tag-tipo tipo-<?= htmlspecialchars($pokemon['tipo_primario']) ?>" style="display: inline-block; margin-top: 6px;">
                        <?= ucfirst(htmlspecialchars($pokemon['tipo_primario'])) ?>
                    </span>
                </div>
            </div>

            <?php if ($erro): ?>
                <div style="background-color: #f8d7da; color: #721c24; padding: 12px; border-radius: 6px; margin-bottom: 20px; text-align: center;">
                    <?= htmlspecialchars($erro) ?>
                </div>
            <?php endif; ?>

            <form action="solicitar-adocao.php?id=<?= $pokemon['id'] ?>" method="post" style="display: flex; flex-direction: column; gap: 18px;">
                <input type="hidden" name="csrf_token" value="<?= Csrf::generateToken() ?>">

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div class="campo-filtro">
                        <label for="data_visita">Data da Visita *</label>
                        <input type="date" id="data_visita" name="data_visita" required min="<?= date('Y-m-d', strtotime('+1 day')) ?>">
                    </div>

                    <div class="campo-filtro">
                        <label for="hora_visita">Horário Preferencial *</label>
                        <select id="hora_visita" name="hora_visita" required>
                            <option value="">Selecione...</option>
                            <option value="09:00">09:00 - Manhã</option>
                            <option value="10:30">10:30 - Manhã</option>
                            <option value="13:30">13:30 - Tarde</option>
                            <option value="15:00">15:00 - Tarde</option>
                            <option value="16:30">16:30 - Tarde</option>
                        </select>
                    </div>
                </div>

                <div class="campo-filtro">
                    <label for="observacoes">Observações / Alguma necessidade especial?</label>
                    <textarea id="observacoes" name="observacoes" rows="3" placeholder="Ex: Tenho outros Pokémon em casa, preciso de orientações para adaptação."></textarea>
                </div>

                <div style="display: flex; gap: 10px; margin-top: 10px;">
                    <button type="submit" class="btn-filtrar" style="flex: 1; padding: 12px; cursor: pointer;">Confirmar Agendamento</button>
                    <a href="pokemon.php" class="btn-filtrar" style="background: #6c757d; text-decoration: none; text-align: center; flex: 1; padding: 12px;">Cancelar</a>
                </div>
            </form>
        </div>
    </main>

    <footer id="rodape">
        <div class="rodape-direitos">
            <p>&copy; 2026 PokéLar. Todos os direitos reservados.</p>
        </div>
    </footer>

</body>
</html>