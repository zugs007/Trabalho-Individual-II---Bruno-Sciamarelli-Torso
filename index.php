<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PokéLar - Centro de Resgate e Adoção Pokémon</title>

    <!-- Preload da imagem do Hero para resolver 'LCP request discovery' -->
    <link rel="preload" as="image" href="img/bg-hero.jpg">

    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <header id="cabeca">
        <div id="cabeca-container">
            <a href="index.html" id="brand">
                <h1>PokéLar</h1>
            </a>

            <nav id="nav" aria-label="Navegação Principal">
                <a href="index.html" class="nav-link ativo" aria-current="page">Início</a>
                <a href="pokemon.html" class="nav-link">Pokémon Disponíveis</a>
                <a href="como-adotar.html" class="nav-link">Como Adotar</a>
                <a href="sobre.html" class="nav-link">Sobre Nós</a>
                <a href="login.html" class="nav-link nav-destaque">Login</a>
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
                    <a href="pokemon.html" class="btn-hero-primario">Quero Adotar</a>
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

        <!-- Como Ajudar -->
        <section id="como-ajudar">
            <h2>Como Você Pode Ajudar</h2>
            <div class="ajuda-grid">
                <article class="card-ajuda">
                    <div>
                        <h3>PIX Solidário</h3>
                        <p>Contribua com qualquer valor para financiar Berries e Potions para os resgatados em reabilitação.</p>
                    </div>
                    <a href="#" class="botao">Fazer Doação</a>
                </article>

                <article class="card-ajuda">
                    <div>
                        <h3>Doação de Suprimentos</h3>
                        <p>Aceitamos Pokébolas, mantas, brinquedos e itens de restauração em nosso centro de acolhimento.</p>
                    </div>
                    <a href="#" class="botao">Pontos de Coleta</a>
                </article>

                <article class="card-ajuda">
                    <div>
                        <h3>Seja Voluntário</h3>
                        <p>Doe seu tempo para ajudar na socialização, passeios e cuidados diários com os Pokémon.</p>
                    </div>
                    <a href="#" class="botao">Quero Ser Voluntário</a>
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