<?php
require_once 'config/database.php';
require_once 'src/Auth.php';
require_once 'src/Csrf.php';

// Garante que a sessão está ativa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Array de tipos oficiais de Pokémon
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

// Captura e sanitiza os filtros recebidos via GET
$busca_nome  = isset($_GET['nome']) ? trim($_GET['nome']) : '';
$filtro_tipo  = isset($_GET['tipo']) ? trim($_GET['tipo']) : '';
$filtro_porte = isset($_GET['porte']) ? trim($_GET['porte']) : '';

// Consulta SQL para buscar todos os Pokémon
$sql = "SELECT * FROM pokemons WHERE 1=1";
$params = [];

if (!empty($busca_nome)) {
    $sql .= " AND nome LIKE :nome";
    $params[':nome'] = '%' . $busca_nome . '%';
}

if (!empty($filtro_tipo)) {
    $sql .= " AND (tipo_primario = :tipo1 OR tipo_secundario = :tipo2)";
    $params[':tipo1'] = $filtro_tipo;
    $params[':tipo2'] = $filtro_tipo;
}

if (!empty($filtro_porte)) {
    $sql .= " AND porte = :porte";
    $params[':porte'] = $filtro_porte;
}

$sql .= " ORDER BY id DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$pokemons = $stmt->fetchAll();

$pagina_atual = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokémon Disponíveis - PokéLar</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <!-- CABEÇALHO FIXO -->
    <header id="cabeca">
        <div id="cabeca-container">
            <a href="index.php" id="brand">
                <h1>PokéLar</h1>
            </a>
            <nav id="nav" aria-label="Navegação Principal">
                <a href="index.php" class="nav-link <?= $pagina_atual === 'index.php' ? 'ativo' : '' ?>">Início</a>
                <a href="pokemon.php" class="nav-link <?= $pagina_atual === 'pokemon.php' ? 'ativo' : '' ?>">Pokémon Disponíveis</a>
                <a href="como-adotar.php" class="nav-link <?= $pagina_atual === 'como-adotar.php' ? 'ativo' : '' ?>">Como Adotar</a>
                <a href="sobre.php" class="nav-link <?= $pagina_atual === 'sobre.php' ? 'ativo' : '' ?>">Sobre Nós</a>

                <?php if (Auth::check()): ?>
                    <?php if (Auth::isAdmin()): ?>
                        <a href="admin/index.php" class="nav-link nav-destaque">Painel Admin</a>
                    <?php else: ?>
                        <a href="minha-conta.php" class="nav-link <?= $pagina_atual === 'minha-conta.php' ? 'ativo' : '' ?>">Minha Conta</a>
                    <?php endif; ?>
                    <a href="logout.php" class="nav-link" style="background-color: #dc3545; color: white;">Sair</a>
                <?php else: ?>
                    <a href="login.php" class="nav-link nav-destaque <?= $pagina_atual === 'login.php' ? 'ativo' : '' ?>">Login</a>
                <?php endif; ?>
            </nav>
            <div id="contato-rapido">
                <a href="https://wa.me/5511941984860" target="_blank" rel="noopener noreferrer" title="Falar no WhatsApp">(11) 94198-4860</a>
            </div>
        </div>
        <div id="linha">
            <button id="bola" onclick="alert('Conheça nossos companheiros em busca de um lar!')" title="Clique para uma surpresa" type="button">
                <img src="img/botao_pokebola.png" alt="Pokébola Interativa" width="58" height="58">
            </button>
        </div>
    </header>

    <!-- CONTEÚDO PRINCIPAL -->
    <main>
        <section class="pagina-cabecalho">
            <div class="container">
                <span class="badge-tag">🐾 Nossos Resgatados</span>
                <h2>Pokémon Disponíveis para Adoção</h2>
                <p>Conheça os Pokémon que estão sob os cuidados do PokéLar aguardando por uma nova família e um lar amoroso.</p>
            </div>
        </section>

        <div class="pagina-conteudo">
            <div class="container">

                <!-- Painel de Filtros -->
                <div class="painel-filtros mb-4">
                    <form action="pokemon.php" method="get" class="form-filtros" role="search">
                        <div class="campo-filtro">
                            <label for="busca-nome">Buscar por nome:</label>
                            <input type="search" id="busca-nome" name="nome" value="<?= htmlspecialchars($busca_nome) ?>" placeholder="Ex: Bulbasaur, Pikachu...">
                        </div>

                        <div class="campo-filtro">
                            <label for="filtro-tipo">Tipo:</label>
                            <select id="filtro-tipo" name="tipo">
                                <option value="">Todos os tipos</option>
                                <?php foreach ($tipos_pokemon as $chave => $rotulo): ?>
                                    <option value="<?= $chave ?>" <?= $filtro_tipo === $chave ? 'selected' : '' ?>>
                                        <?= $rotulo ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="campo-filtro">
                            <label for="filtro-porte">Porte:</label>
                            <select id="filtro-porte" name="porte">
                                <option value="">Todos os portes</option>
                                <option value="pequeno" <?= $filtro_porte === 'pequeno' ? 'selected' : '' ?>>Pequeno</option>
                                <option value="medio" <?= $filtro_porte === 'medio' ? 'selected' : '' ?>>Médio</option>
                                <option value="grande" <?= $filtro_porte === 'grande' ? 'selected' : '' ?>>Grande</option>
                            </select>
                        </div>

                        <button type="submit" class="btn-filtrar">Filtrar</button>
                    </form>
                </div>

                <!-- Grade de Pokémon -->
                <div class="grid-pokemon">
                    <?php if (count($pokemons) > 0): ?>
                        <?php foreach ($pokemons as $poke): ?>
                            <article class="card-pokemon">
                                <div class="card-pokemon-imagem">
                                    <?php if ($poke['status'] === 'disponivel'): ?>
                                        <span class="badge-status disponivel">Disponível</span>
                                    <?php elseif ($poke['status'] === 'em-processo'): ?>
                                        <span class="badge-status em-processo">Em Análise</span>
                                    <?php else: ?>
                                        <span class="badge-status" style="background-color: #6c757d; color: white;">Adotado</span>
                                    <?php endif; ?>
                                    <img src="<?= htmlspecialchars($poke['imagem']) ?>" alt="<?= htmlspecialchars($poke['alt_texto'] ?? $poke['nome']) ?>" width="280" height="200" loading="lazy">
                                </div>
                                <div class="card-pokemon-corpo">
                                    <div class="tags-tipo">
                                        <span class="tag-tipo tipo-<?= htmlspecialchars($poke['tipo_primario']) ?>">
                                            <?= ucfirst(htmlspecialchars($poke['tipo_primario'])) ?>
                                        </span>
                                        <?php if (!empty($poke['tipo_secundario'])): ?>
                                            <span class="tag-tipo tipo-<?= htmlspecialchars($poke['tipo_secundario']) ?>">
                                                <?= ucfirst(htmlspecialchars($poke['tipo_secundario'])) ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    <h3><?= htmlspecialchars($poke['nome']) ?></h3>
                                    <ul class="info-caracteristicas">
                                        <li><strong>Idade:</strong> <?= htmlspecialchars($poke['idade']) ?></li>
                                        <li><strong>Temperamento:</strong> <?= htmlspecialchars($poke['temperamento']) ?></li>
                                        <li><strong>Local de Resgate:</strong> <?= htmlspecialchars($poke['local_resgate']) ?></li>
                                    </ul>
                                    <p class="descricao-resumida"><?= htmlspecialchars($poke['descricao']) ?></p>

                                    <!-- AÇÕES DO CARD -->
                                    <div class="card-pokemon-acoes" style="margin-top: 15px;">
                                        <?php if ($poke['status'] === 'disponivel'): ?>
                                            <?php if (Auth::check()): ?>
                                                <a href="solicitar-adocao.php?id=<?= $poke['id'] ?>" class="btn-card-adotar" style="display: block; text-align: center; text-decoration: none; font-weight: bold; width: 100%;">
                                                    📅 Quero Adotar (Agendar Visita)
                                                </a>
                                            <?php else: ?>
                                                <a href="login.php?erro=acesso_negado" class="btn-card-adotar" style="display: block; text-align: center; text-decoration: none;">
                                                    Login para Adotar
                                                </a>
                                            <?php endif; ?>
                                        <?php elseif ($poke['status'] === 'em-processo'): ?>
                                            <button class="btn-card-adotar desabilitado" disabled style="width: 100%; background: #f59e0b; cursor: not-allowed; border: none; padding: 10px; color: white; border-radius: 6px;">
                                                Visita Agendada / Em Análise
                                            </button>
                                        <?php else: ?>
                                            <button class="btn-card-adotar desabilitado" disabled style="width: 100%; background: #6c757d; cursor: not-allowed; border: none; padding: 10px; color: white; border-radius: 6px;">
                                                Já Adotado ❤️
                                            </button>
                                        <?php endif; ?>
                                    </div>

                                </div>
                            </article>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="sem-resultados">Nenhum Pokémon encontrado com os filtros selecionados.</p>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </main>

    <!-- RODAPÉ -->
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