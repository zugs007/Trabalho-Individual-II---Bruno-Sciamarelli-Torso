<?php
require_once '../config/database.php';
require_once '../src/Auth.php';
require_once '../src/Csrf.php';
require_once '../src/Logger.php';

Auth::requireAdmin();

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

$erro = '';
$sucesso = '';

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
    $imagem         = trim($_POST['imagem'] ?? 'img/default.png');
    $alt_texto      = trim($_POST['alt_texto'] ?? '');
    $descricao      = trim($_POST['descricao'] ?? '');

    if (!Csrf::validateToken($token)) {
        $erro = 'Erro de validação CSRF. Tente novamente.';
    } elseif (empty($nome) || empty($tipo_primario) || empty($porte) || empty($idade) || empty($local_resgate) || empty($descricao)) {
        $erro = 'Por favor, preencha todos os campos obrigatórios (*).';
    } else {
        try {
            $sql = "INSERT INTO pokemons (nome, tipo_primario, tipo_secundario, porte, idade, temperamento, local_resgate, status, imagem, alt_texto, descricao) 
                    VALUES (:nome, :tipo_primario, :tipo_secundario, :porte, :idade, :temperamento, :local_resgate, :status, :imagem, :alt_texto, :descricao)";
            
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
                ':alt_texto'      => !empty($alt_texto) ? $alt_texto : "Imagem de " . $nome,
                ':descricao'      => $descricao
            ]);

            Logger::log("Novo Pokémon cadastrado: {$nome} (ID: " . $pdo->lastInsertId() . ") por " . $_SESSION['usuario_email'], "INFO");
            header('Location: index.php?msg=cadastrado');
            exit;
        } catch (PDOException $e) {
            Logger::log("Erro ao cadastrar Pokémon: " . $e->getMessage(), "ERROR");
            $erro = "Erro no banco de dados ao salvar o registro.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Pokémon - PokéLar Admin</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

    <header id="cabeca">
        <div id="cabeca-container">
            <a href="../index.php" id="brand"><h1>PokéLar</h1></a>
            <nav id="nav">
                <a href="../index.php" class="nav-link">Início</a>
                <a href="../pokemon.php" class="nav-link">Catálogo</a>
                <a href="index.php" class="nav-link nav-destaque ativo">Painel Admin</a>
                <a href="../logout.php" class="nav-link" style="background-color: #dc3545;">Sair</a>
            </nav>
        </div>
        <div id="linha">
            <button id="bola" type="button"><img src="../img/botao_pokebola.png" alt="Pokébola" width="58" height="58"></button>
        </div>
    </header>

    <main class="container py-5" style="max-width: 700px; margin: 40px auto;">
        <h2>Cadastrar Novo Pokémon</h2>
        
        <?php if ($erro): ?>
            <div style="background: #f8d7da; color: #721c24; padding: 12px; border-radius: 6px; margin-bottom: 20px;"><?= htmlspecialchars($erro) ?></div>
        <?php endif; ?>

        <form action="create.php" method="post" class="painel-filtros" style="display: flex; flex-direction: column; gap: 15px;">
            <input type="hidden" name="csrf_token" value="<?= Csrf::generateToken() ?>">

            <div class="campo-filtro">
                <label for="nome">Nome do Pokémon *</label>
                <input type="text" id="nome" name="nome" required placeholder="Ex: Pikachu">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                <div class="campo-filtro">
                    <label for="tipo_primario">Tipo Primário *</label>
                    <select id="tipo_primario" name="tipo_primario" required>
                        <?php foreach ($tipos_pokemon as $chave => $rotulo): ?>
                            <option value="<?= $chave ?>"><?= $rotulo ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="campo-filtro">
                    <label for="tipo_secundario">Tipo Secundário</label>
                    <select id="tipo_secundario" name="tipo_secundario">
                        <option value="">Nenhum</option>
                        <?php foreach ($tipos_pokemon as $chave => $rotulo): ?>
                            <option value="<?= $chave ?>"><?= $rotulo ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                <div class="campo-filtro">
                    <label for="porte">Porte *</label>
                    <select id="porte" name="porte" required>
                        <option value="pequeno">Pequeno</option>
                        <option value="medio">Médio</option>
                        <option value="grande">Grande</option>
                    </select>
                </div>
                <div class="campo-filtro">
                    <label for="status">Status *</label>
                    <select id="status" name="status" required>
                        <option value="disponivel">Disponível</option>
                        <option value="em-processo">Em Processo</option>
                        <option value="adotado">Adotado</option>
                    </select>
                </div>
            </div>

            <div class="campo-filtro">
                <label for="idade">Idade *</label>
                <input type="text" id="idade" name="idade" required placeholder="Ex: Filhote (1 ano)">
            </div>

            <div class="campo-filtro">
                <label for="temperamento">Temperamento *</label>
                <input type="text" id="temperamento" name="temperamento" required placeholder="Ex: Brincalhão e dócil">
            </div>

            <div class="campo-filtro">
                <label for="local_resgate">Local de Resgate *</label>
                <input type="text" id="local_resgate" name="local_resgate" required placeholder="Ex: Floresta de Viridian">
            </div>

            <div class="campo-filtro">
                <label for="imagem">Caminho da Imagem</label>
                <input type="text" id="imagem" name="imagem" value="img/pikachu.png" placeholder="Ex: img/pikachu.png">
            </div>

            <div class="campo-filtro">
                <label for="descricao">Descrição Completa *</label>
                <textarea id="descricao" name="descricao" rows="4" required placeholder="Descreva os hábitos, saúde e história do resgatado..."></textarea>
            </div>

            <div style="display: flex; gap: 10px; margin-top: 10px;">
                <button type="submit" class="btn-filtrar" style="flex: 1;">Salvar Registro</button>
                <a href="index.php" class="btn-filtrar" style="background: #6c757d; text-decoration: none; text-align: center; flex: 1;">Cancelar</a>
            </div>
        </form>
    </main>

</body>
</html>