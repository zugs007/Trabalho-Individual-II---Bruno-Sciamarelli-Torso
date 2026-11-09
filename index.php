<?php
require_once 'src/Auth.php';
$pagina_atual = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PokéLar - Centro de Resgate e Adoção Pokémon</title>

    <!-- Preload da imagem do Hero -->
    <link rel="preload" as="image" href="img/bg-hero.jpg">

    <link rel="stylesheet" href="css/style.css">

    <!-- Estilos do Modal PIX -->
    <style>
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.65);
            backdrop-filter: blur(4px);
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .modal-conteudo {
            background: #ffffff;
            padding: 30px;
            border-radius: var(--raio-borda);
            max-width: 420px;
            width: 90%;
            position: relative;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.25);
            animation: modalSlide 0.3s ease;
        }
        .modal-fechar {
            position: absolute;
            top: 15px;
            right: 18px;
            background: none;
            border: none;
            font-size: 1.8rem;
            cursor: pointer;
            color: var(--texto-suave);
            line-height: 1;
        }
        .modal-fechar:hover {
            color: #dc3545;
        }
        @keyframes modalSlide {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

    <!-- CABEÇALHO FIXO DO SITE -->
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
            <button id="bola" onclick="alert('Bem-vindo ao PokéLar!')" title="Clique para uma surpresa" type="button">
                <img src="img/botao_pokebola.png" alt="Pokébola Interativa" width="58" height="58">
            </button>
        </div>
    </header>

    <main>
        <!-- Hero Banner -->
        <section id="fotoBulba">
            <div id="textoBulba">
                <span class="badge-tag">🐾 Centro de Resgate PokéLar</span>
                <h2>Faça a diferença e dê um lar a quem precisa.</h2>
                <p>Dezenas de Pokémon resgatados nas rotas de Kanto aguardam por uma segunda chance. Encontre seu novo companheiro de jornada hoje mesmo.</p>
                
                <div class="hero-botoes">
                    <a href="pokemon.php" class="btn-hero-primario">Quero Adotar</a>
                    <a href="#como-ajudar" class="btn-hero-secundario">Como Ajudar</a>
                </div>
            </div>
        </section>

        <!-- Contador de Impacto -->
        <section id="impacto">
            <h2>Nosso Impacto em Kanto</h2>
            <div class="impacto-grid">
                <article class="card-impacto">
                    <h3>+250</h3>
                    <p>Pokémon Resgatados</p>
                </article>
                <article class="card-impacto">
                    <h3>180</h3>
                    <p>Adoções Concluídas</p>
                </article>
                <article class="card-impacto">
                    <h3>100%</h3>
                    <p>Atendimento Veterinário</p>
                </article>
            </div>
        </section>

        <!-- Como Ajudar INTERATIVO -->
        <!-- Como Ajudar INTERATIVO -->
        <section id="como-ajudar">
            <h2>Como Você Pode Ajudar</h2>
            <div class="ajuda-grid">
                
                <!-- Card 1: PIX Solidário com Modal -->
                <article class="card-ajuda">
                    <div>
                        <h3>PIX Solidário</h3>
                        <p>Contribua com qualquer valor para financiar Berries e Potions para os resgatados em reabilitação.</p>
                    </div>
                    <a href="javascript:void(0)" onclick="abrirModalPix()" class="botao">
                        Fazer Doação
                    </a>
                </article>

                <!-- Card 2: Suprimentos via WhatsApp -->
                <article class="card-ajuda">
                    <div>
                        <h3>Doação de Suprimentos</h3>
                        <p>Aceitamos Pokébolas, mantas, brinquedos e itens de restauração em nosso centro de acolhimento.</p>
                    </div>
                    <a href="https://wa.me/5511941984860?text=Olá!%20Gostaria%20de%20combinar%20uma%20doação%20de%20suprimentos%20para%20o%20PokéLar." target="_blank" rel="noopener noreferrer" class="botao">
                        Pontos de Coleta
                    </a>
                </article>

                <!-- Card 3: Voluntariado via WhatsApp -->
                <article class="card-ajuda">
                    <div>
                        <h3>Seja Voluntário</h3>
                        <p>Doe seu tempo para ajudar na socialização, passeios e cuidados diários com os Pokémon.</p>
                    </div>
                    <a href="https://wa.me/5511941984860?text=Olá!%20Tenho%20interesse%20em%20ser%20voluntário%20no%20PokéLar." target="_blank" rel="noopener noreferrer" class="botao">
                        Quero Ser Voluntário
                    </a>
                </article>
            </div>
        </section>

        <!-- Histórias de Adoção -->
        <section id="adotantes" class="container py-5">
            <div class="titulo-secao">
                <h2>Histórias de Amor e Adoção</h2>
                <p>Veja quem já encontrou seu parceiro para a vida toda em nosso centro!</p>
            </div>

            <div class="grid-adotantes">
                <article class="card-adotante">
                    <div class="card-foto">
                        <img src="img/mistytogepi.jpg" alt="Misty segurando o Togepi" width="400" height="350" loading="lazy">
                        <span class="badge-tipo">Adoção desde Ovo</span>
                    </div>
                    <div class="card-conteudo">
                        <h3>Misty & Togepi</h3>
                        <p class="depoimento">
                            "Quando o Togepi chocou, ele olhou pra mim e soube que éramos uma família. Adoção é criar esse vínculo único de carinho e proteção todos os dias!"
                        </p>
                        <span class="autor-depoimento">— Misty, Líder de Ginásio & Tutora</span>
                    </div>
                </article>

                <article class="card-adotante">
                    <div class="card-foto">
                        <img src="img/brockgeodude.png" alt="Brock segurando o Geodude" width="400" height="350" loading="lazy">
                        <span class="badge-tipo">Cuidados Especiais</span>
                    </div>
                    <div class="card-conteudo">
                        <h3>Brock & Geodude</h3>
                        <p class="depoimento">
                            "Muitos acham que Pokémon de Pedra não exigem atenção, mas o Geodude ama um bom polimento e comida de qualidade. Todo Pokémon merece um lar responsável!"
                        </p>
                        <span class="autor-depoimento">— Brock, Criador Pokémon & Tutor</span>
                    </div>
                </article>
            </div>
        </section>
    </main>

    <!-- MODAL POPUP PIX SOLIDÁRIO -->
    <div id="modal-pix" class="modal-overlay" style="display: none;">
        <div class="modal-conteudo">
            <button class="modal-fechar" onclick="fecharModalPix()" title="Fechar">&times;</button>
            <div style="text-align: center;">
                <span style="font-size: 2.5rem; display: block; margin-bottom: 5px;">⚡</span>
                <h3 style="margin: 0 0 8px 0; color: var(--texto-escuro); font-size: 1.4rem;">PIX Solidário PokéLar</h3>
                <p style="color: var(--texto-suave); font-size: 0.9rem; margin-bottom: 18px; line-height: 1.4;">
                    Sua doação ajuda a comprar Berries, Potions e suprimentos veterinários para nossos resgatados!
                </p>

                <div style="background: #f8f9fa; padding: 15px; border-radius: 12px; border: 1px solid var(--borda-suave); margin-bottom: 20px;">
                    <!-- Gerador Automático do QR Code com a Chave PIX -->
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=11941984860" alt="QR Code PIX PokéLar" width="180" height="180" style="margin: 0 auto 10px auto; border-radius: 8px; border: 1px solid #ddd;">
                    
                    <p style="margin: 5px 0 4px 0; font-weight: bold; font-size: 0.85rem; color: var(--texto-suave);">Chave PIX (Telefone):</p>
                    <code style="background: #e2e8f0; padding: 6px 12px; border-radius: 6px; font-size: 1.05rem; font-weight: bold; color: var(--verde-texto); display: inline-block;">(11) 94198-4860</code>
                </div>

                <button onclick="copiarPix()" class="btn-filtrar" style="width: 100%; border: none; cursor: pointer; padding: 12px; font-weight: bold;">
                    📋 Copiar Chave PIX
                </button>
            </div>
        </div>
    </div>

    <!-- SCRIPT DE CONTROLE DO MODAL PIX -->
    <script>
        function abrirModalPix() {
            document.getElementById('modal-pix').style.display = 'flex';
        }

        function fecharModalPix() {
            document.getElementById('modal-pix').style.display = 'none';
        }

        function copiarPix() {
            navigator.clipboard.writeText('11941984860').then(() => {
                alert('Chave PIX (11941984860) copiada com sucesso!');
            }).catch(() => {
                alert('Chave PIX: 11941984860');
            });
        }

        // Fechar modal ao clicar fora da caixa de conteúdo
        window.onclick = function(event) {
            const modal = document.getElementById('modal-pix');
            if (event.target === modal) {
                fecharModalPix();
            }
        };
    </script>

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
                <p>
                    <img src="img/whatsapp.png" alt="" class="icone-contato" width="20" height="20" aria-hidden="true" loading="lazy">
                    <strong>WhatsApp:</strong> <a href="https://wa.me/5511941984860" target="_blank" rel="noopener noreferrer">(11) 94198-4860</a>
                </p>
                <p>
                    <img src="img/telefone.png" alt="" class="icone-contato" width="20" height="20" aria-hidden="true" loading="lazy">
                    <strong>Telefone Fixo:</strong> (11) 3456-7890
                </p>
                <p>
                    <img src="img/instagram.png" alt="" class="icone-contato" width="20" height="20" aria-hidden="true" loading="lazy">
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