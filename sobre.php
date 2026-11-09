<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre Nós - PokéLar</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <header id="cabeca">
        <div id="cabeca-container">
            <a href="index.html" id="brand">
                <h1>PokéLar</h1>
            </a>

            <nav id="nav" aria-label="Navegação Principal">
                <a href="index.html" class="nav-link">Início</a>
                <a href="pokemon.html" class="nav-link">Pokémon Disponíveis</a>
                <a href="como-adotar.html" class="nav-link">Como Adotar</a>
                <a href="sobre.html" class="nav-link ativo">Sobre Nós</a>
                <a href="login.html" class="nav-link nav-destaque">Login</a>
            </nav>

            <div id="contato-rapido">
                <a href="https://wa.me/5511941984860" target="_blank" rel="noopener noreferrer" title="Falar no WhatsApp">(11) 94198-4860</a>
            </div>
        </div>

        <div id="linha">
            <button id="bola" onclick="alert('Bem-vindo ao PokéLar! Conheça nossa história.')" title="Clique para uma surpresa" type="button">
                <img src="img/botao_pokebola.png" alt="Pokébola Interativa" width="58" height="58">
            </button>
        </div>
    </header>

    <main>
        <section class="pagina-cabecalho">
            <div class="container">
                <span class="badge-tag">🏠 Conheça o PokéLar</span>
                <h2>Nossa História e Propósito</h2>
                <p>Nascemos do amor, do acolhimento e da esperança de dar a cada Pokémon o lar que ele merece.</p>
            </div>
        </section>

        <section class="pagina-conteudo">
            <div class="container">

                <article class="card-sobre">
                    <span class="badge-tag badge-purple">💜 As Raízes em Kanto</span>
                    <h3>Da Casa dos Pokémon para o Mundo</h3>
                    
                    <p>
                        A história do <strong>PokéLar</strong> começou há muitos anos nas ruas silenciosas de <strong>Lavender Town</strong>. Nosso fundador cresceu sob os cuidados e ensinamentos do bondoso <strong>Sr. Fuji</strong> na <em>Casa de Voluntários Pokémon de Lavender</em>, um abrigo dedicado a cuidar de criaturinhas que haviam perdido seus lares ou passado por momentos difíceis.
                    </p>
                    
                    <p>
                        Foi observando a paciência com que o Sr. Fuji reabilitava desde traumatizados Cubones até jovens Bulbasauros abandonados por treinadores inexperientes que nasceu a missão de uma vida: criar um centro especializado não apenas no resgate, mas na <strong>adoção consciente e amorosa de Pokémon em toda a região</strong>.
                    </p>
                </article>

                <article class="card-sobre">
                    <span class="badge-tag">🤝 Redes de Apoio</span>
                    <h3>Apoiado por Figuras Notáveis</h3>
                    
                    <p>
                        O sonho da ONG tomou proporções maiores quando o projeto recebeu o apadrinhamento direto do próprio <strong>Sr. Fuji</strong> e o suporte técnico de pesquisadores do Laboratório do <strong>Professor Carvalho</strong> em Pallet Town.
                    </p>
                    
                    <p>
                        Com essa forte rede de apoio, o PokéLar evoluiu de um pequeno refúgio temporário para um centro de reabilitação e adoção estruturado, com equipe veterinária, especialistas em comportamento e espaços abertos adaptados para os mais diversos tipos de Pokémon — dos aquáticos aos elétricos.
                    </p>
                </article>

                <div class="titulo-secao">
                    <h2>Nossos Pilares</h2>
                    <p>O que guia nossas ações e cuidados todos os dias.</p>
                </div>

                <div class="impacto-grid mb-4">
                    <div class="card-ajuda">
                        <div>
                            <span class="icone-pilar">❤️</span>
                            <h3>Missão</h3>
                            <p>Resgatar, reabilitar e promover a adoção responsável de Pokémon abandonados ou resgatados, garantindo a eles uma vida segura e cheia de afeto.</p>
                        </div>
                    </div>

                    <div class="card-ajuda">
                        <div>
                            <span class="icone-pilar">🌟</span>
                            <h3>Visão</h3>
                            <p>Um mundo onde nenhum Pokémon sofra por abandono ou maus-tratos, e onde a amizade entre humanos e Pokémon seja baseada no respeito mútuo.</p>
                        </div>
                    </div>

                    <div class="card-ajuda">
                        <div>
                            <span class="icone-pilar">🤝</span>
                            <h3>Valores</h3>
                            <p>Empatia, transparência no processo seletivo de adotantes, dedicação ao bem-estar e amor incondicional a todas as espécies.</p>
                        </div>
                    </div>
                </div>

                <div class="cta-box">
                    <h3>Quer fazer parte dessa história?</h3>
                    <p>
                        Seja adotando um novo parceiro de jornada, sendo um voluntário em nossa sede ou fazendo uma doação para suprir rações e itens medicinais.
                    </p>
                    <div class="cta-botoes">
                        <a href="pokemon.html" class="btn-cta-primario">Conhecer Pokémon</a>
                        <a href="https://wa.me/5511941984860" target="_blank" rel="noopener noreferrer" class="btn-cta-secundario">Falar Conosco</a>
                    </div>
                </div>

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
                    <img src="img/whatsapp.png" alt="" class="icone-contato" width="20" height="20" aria-hidden="true">
                    <strong>WhatsApp:</strong> <a href="https://wa.me/5511941984860" target="_blank" rel="noopener noreferrer">(11) 94198-4860</a>
                </p>
                <p>
                    <img src="img/telefone.png" alt="" class="icone-contato" width="20" height="20" aria-hidden="true">
                    <strong>Telefone Fixo:</strong> (11) 3456-7890
                </p>
                <p>
                    <img src="img/instagram.png" alt="" class="icone-contato" width="20" height="20" aria-hidden="true">
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