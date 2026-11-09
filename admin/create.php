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
    $token           = $_POST['csrf_token'] ?? '';
    $nome            = trim($_POST['nome'] ?? '');
    $tipo_primario   = trim($_POST['tipo_primario'] ?? '');
    $tipo_secundario = trim($_POST['tipo_secundario'] ?? '');
    $porte           = trim($_POST['porte'] ?? '');
    $idade           = trim($_POST['idade'] ?? '');
    $temperamento    = trim($_POST['temperamento'] ?? '');
    $local_resgate   = trim($_POST['local_resgate'] ?? '');
    $status          = trim($_POST['status'] ?? 'disponivel');
    $alt_texto       = trim($_POST['alt_texto'] ?? '');
    $descricao       = trim($_POST['descricao'] ?? '');

    if (!Csrf::validateToken($token)) {
        $erro = 'Erro de validação CSRF. Tente novamente.';
    } elseif (empty($nome) || empty($tipo_primario) || empty($porte) || empty($idade) || empty($local_resgate) || empty($descricao)) {
        $erro = 'Por favor, preencha todos os campos obrigatórios (*).';
    } elseif (!isset($_FILES['imagem_arquivo']) || $_FILES['imagem_arquivo']['error'] !== UPLOAD_ERR_OK) {
        $erro = 'Por favor, selecione um arquivo de imagem válido.';
    } else {
        // --- PROCESSAMENTO DO UPLOAD DE IMAGEM ---
        $arquivo = $_FILES['imagem_arquivo'];
        $extensao = strtolower(pathinfo($arquivo['name'], PATHINFO_EXTENSION));
        $extensoesPermitidas = ['jpg', 'jpeg', 'png', 'webp'];

        if (!in_array($extensao, $extensoesPermitidas, true)) {
            $erro = 'Formato de imagem inválido. Aceitos apenas: JPG, JPEG, PNG e WEBP.';
        } elseif ($arquivo['size'] > 3 * 1024 * 1024) { // Limite de 3MB
            $erro = 'A imagem deve ter no máximo 3MB.';
        } else {
            // Gera um nome de arquivo único para não sobrescrever imagens com o mesmo nome
            $novoNomeArquivo = uniqid('poke_', true) . '.' . $extensao;
            
            // Caminho onde o arquivo será salvo no servidor
            $diretorioDestino = '../uploads/';
            $caminhoServidor  = $diretorioDestino . $novoNomeArquivo;
            
            // Caminho que será salvo no banco de dados para ser exibido nas páginas públicas
            $caminhoBancoData = 'uploads/' . $novoNomeArquivo;

            // Cria o diretório de uploads se ainda não existir
            if (!is_dir($diretorioDestino)) {
                mkdir($diretorioDestino, 0755, true);
            }

            if (move_uploaded_file($arquivo['tmp_name'], $caminhoServidor)) {
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
                        ':imagem'         => $caminhoBancoData,
                        ':alt_texto'      => !empty($alt_texto) ? $alt_texto : "Imagem de " . $nome,
                        ':descricao'      => $descricao
                    ]);

                    Logger::log("Novo Pokémon cadastrado via upload: {$nome} (ID: " . $pdo->lastInsertId() . ") por " . $_SESSION['usuario_email'], "INFO");
                    header('Location: index.php?msg=cadastrado');
                    exit;
                } catch (PDOException $e) {
                    Logger::log("Erro ao cadastrar Pokémon: " . $e->getMessage(), "ERROR");
                    $erro = "Erro no banco de dados ao salvar o registro.";
                }
            } else {
                $erro = "Falha ao enviar o arquivo de imagem para o servidor.";
            }
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


    <main class="container py-5" style="max-width: 700px; margin: 40px auto;">
        <h2>Cadastrar Novo Pokémon</h2>
        
        <?php if ($erro): ?>
            <div style="background: #f8d7da; color: #721c24; padding: 12px; border-radius: 6px; margin-bottom: 20px;"><?= htmlspecialchars($erro) ?></div>
        <?php endif; ?>

        <!-- Note a presença de enctype="multipart/form-data" para permitir envio de arquivos -->
        <form action="create.php" method="post" enctype="multipart/form-data" class="painel-filtros" style="display: flex; flex-direction: column; gap: 15px;">
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

            <!-- CAMPO DE UPLOAD DE ARQUIVO -->
            <div class="campo-filtro">
                <label for="imagem_arquivo">Selecione a Imagem (PNG, JPG ou WEBP) *</label>
                <input type="file" id="imagem_arquivo" name="imagem_arquivo" accept="image/*" required>
            </div>

            <div class="campo-filtro">
                <label for="alt_texto">Texto Alternativo da Imagem (Acessibilidade)</label>
                <input type="text" id="alt_texto" name="alt_texto" placeholder="Ex: Pikachu sorrindo na grama">
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