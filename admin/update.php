<?php
require_once '../config/database.php';
require_once '../src/Auth.php';
require_once '../src/Csrf.php';
require_once '../src/Logger.php';

$tipos_pokemon = [
    'aco'       => 'Aço',
    'agua'      => 'Água',
    'bug'       => 'Inseto',
    'dragao'    => 'Dragão',
    'eletrico'  => 'Elétrico',
    'fada'      => 'Fada',
    'lutador'   => 'Lutador',
    'fogo'      => 'Fogo',
    'voador'    => 'Voador',
    'fantasma'  => 'Fantasma',
    'planta'    => 'Planta',
    'terrestre' => 'Terrestre',
    'gelo'      => 'Gelo',
    'normal'    => 'Normal',
    'veneno'    => 'Veneno',
    'psiquico'  => 'Psíquico',
    'pedra'     => 'Pedra',
    'sombrio'   => 'Sombrio'
];

Auth::requireAdmin();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$erro = '';

// Busca os dados do Pokémon a ser editado
$stmt = $pdo->prepare("SELECT * FROM pokemons WHERE id = :id");
$stmt->execute([':id' => $id]);
$pokemon = $stmt->fetch();

if (!$pokemon) {
    header('Location: index.php?erro=nao_encontrado');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token          = $_POST['csrf_token'] ?? '';
    $nome           = trim($_POST['nome'] ?? '');
    $tipo_primario  = trim($_POST['tipo_primario'] ?? '');
    $tipo_secundario= trim($_POST['tipo_secundario'] ?? '');
    $porte          = trim($_POST['porte'] ?? '');
    $idade          = trim($_POST['idade'] ?? '');
    $temperamento   = trim($_POST['temperamento'] ?? '');
    $local_resgate  = trim($_POST['local_resgate'] ?? '');
    $status         = trim($_POST['status'] ?? 'disponivel');
    $imagem         = trim($_POST['imagem'] ?? '');
    $descricao      = trim($_POST['descricao'] ?? '');

    if (!Csrf::validateToken($token)) {
        $erro = 'Erro de validação CSRF.';
    } elseif (empty($nome) || empty($tipo_primario) || empty($porte) || empty($descricao)) {
        $erro = 'Preencha todos os campos obrigatórios.';
    } else {
        try {
            $sql = "UPDATE pokemons SET 
                    nome = :nome, 
                    tipo_primario = :tipo_primario, 
                    tipo_secundario = :tipo_secundario, 
                    porte = :porte, 
                    idade = :idade, 
                    temperamento = :temperamento, 
                    local_resgate = :local_resgate, 
                    status = :status, 
                    imagem = :imagem, 
                    descricao = :descricao 
                    WHERE id = :id";
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':nome'           => $nome,
                ':tipo_primario'  => $tipo_primario,
                ':tipo_secundario'=> !empty($tipo_secundario) ? $tipo_secundario : null,
                ':porte'          => $porte,
                ':idade'          => $idade,
                ':temperamento'   => $temperamento,
                ':local_resgate'  => $local_resgate,
                ':status'         => $status,
                ':imagem'         => $imagem,
                ':descricao'      => $descricao,
                ':id'             => $id
            ]);

            Logger::log("Pokémon editado: {$nome} (ID: {$id}) por " . $_SESSION['usuario_email'], "INFO");
            header('Location: index.php?msg=editado');
            exit;
        } catch (PDOException $e) {
            Logger::log("Erro ao atualizar Pokémon ID {$id}: " . $e->getMessage(), "ERROR");
            $erro = "Erro ao atualizar registro.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Pokémon - PokéLar Admin</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

    <header id="cabeca">
        <div id="cabeca-container">
            <a href="../index.php" id="brand"><h1>PokéLar</h1></a>
            <nav id="nav">
                <a href="../index.php" class="nav-link">Início</a>
                <a href="index.php" class="nav-link nav-destaque ativo">Painel Admin</a>
                <a href="../logout.php" class="nav-link" style="background-color: #dc3545;">Sair</a>
            </nav>
        </div>
        <div id="linha">
            <button id="bola" type="button"><img src="../img/botao_pokebola.png" alt="Pokébola" width="58" height="58"></button>
        </div>
    </header>

    <main class="container py-5" style="max-width: 700px; margin: 40px auto;">
        <h2>Editar Pokémon #<?= $pokemon['id'] ?> (<?= htmlspecialchars($pokemon['nome']) ?>)</h2>

        <?php if ($erro): ?>
            <div style="background: #f8d7da; color: #721c24; padding: 12px; border-radius: 6px; margin-bottom: 20px;"><?= htmlspecialchars($erro) ?></div>
        <?php endif; ?>

        <form action="update.php?id=<?= $id ?>" method="post" class="painel-filtros" style="display: flex; flex-direction: column; gap: 15px;">
            <input type="hidden" name="csrf_token" value="<?= Csrf::generateToken() ?>">

            <div class="campo-filtro">
                <label for="nome">Nome do Pokémon *</label>
                <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($pokemon['nome']) ?>" required>
            </div>

           <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                <div class="campo-filtro">
                    <label for="tipo_primario">Tipo Primário *</label>
                    <select id="tipo_primario" name="tipo_primario" required>
                        <?php foreach ($tipos_pokemon as $chave => $rotulo): ?>
                            <option value="<?= $chave ?>" <?= $pokemon['tipo_primario'] === $chave ? 'selected' : '' ?>>
                                <?= $rotulo ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="campo-filtro">
                    <label for="tipo_secundario">Tipo Secundário</label>
                    <select id="tipo_secundario" name="tipo_secundario">
                        <option value="">Nenhum</option>
                        <?php foreach ($tipos_pokemon as $chave => $rotulo): ?>
                            <option value="<?= $chave ?>" <?= $pokemon['tipo_secundario'] === $chave ? 'selected' : '' ?>>
                                <?= $rotulo ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                <div class="campo-filtro">
                    <label for="porte">Porte *</label>
                    <select id="porte" name="porte" required>
                        <option value="pequeno" <?= $pokemon['porte'] === 'pequeno' ? 'selected' : '' ?>>Pequeno</option>
                        <option value="medio" <?= $pokemon['porte'] === 'medio' ? 'selected' : '' ?>>Médio</option>
                        <option value="grande" <?= $pokemon['porte'] === 'grande' ? 'selected' : '' ?>>Grande</option>
                    </select>
                </div>
                <div class="campo-filtro">
                    <label for="status">Status *</label>
                    <select id="status" name="status" required>
                        <option value="disponivel" <?= $pokemon['status'] === 'disponivel' ? 'selected' : '' ?>>Disponível</option>
                        <option value="em-processo" <?= $pokemon['status'] === 'em-processo' ? 'selected' : '' ?>>Em Processo</option>
                        <option value="adotado" <?= $pokemon['status'] === 'adotado' ? 'selected' : '' ?>>Adotado</option>
                    </select>
                </div>
            </div>

            <div class="campo-filtro">
                <label for="idade">Idade *</label>
                <input type="text" id="idade" name="idade" value="<?= htmlspecialchars($pokemon['idade']) ?>" required>
            </div>

            <div class="campo-filtro">
                <label for="temperamento">Temperamento *</label>
                <input type="text" id="temperamento" name="temperamento" value="<?= htmlspecialchars($pokemon['temperamento']) ?>" required>
            </div>

            <div class="campo-filtro">
                <label for="local_resgate">Local de Resgate *</label>
                <input type="text" id="local_resgate" name="local_resgate" value="<?= htmlspecialchars($pokemon['local_resgate']) ?>" required>
            </div>

            <div class="campo-filtro">
                <label for="imagem">Caminho da Imagem *</label>
                <input type="text" id="imagem" name="imagem" value="<?= htmlspecialchars($pokemon['imagem']) ?>" required>
            </div>

            <div class="campo-filtro">
                <label for="descricao">Descrição Completa *</label>
                <textarea id="descricao" name="descricao" rows="4" required><?= htmlspecialchars($pokemon['descricao']) ?></textarea>
            </div>

            <div style="display: flex; gap: 10px; margin-top: 10px;">
                <button type="submit" class="btn-filtrar" style="flex: 1;">Atualizar Registro</button>
                <a href="index.php" class="btn-filtrar" style="background: #6c757d; text-decoration: none; text-align: center; flex: 1;">Cancelar</a>
            </div>
        </form>
    </main>

</body>
</html>