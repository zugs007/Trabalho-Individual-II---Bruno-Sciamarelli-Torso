<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Como Adotar - PokéLar</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <!-- CABEÇALHO FIXO DO SITE -->
    <header id="cabeca">
        <div id="cabeca-container">
            <!-- Logo do PokéLar -->
            <a href="index.html" id="brand">
                <h1>PokéLar</h1>
            </a>

            <!-- Navegação Principal -->
            <nav id="nav" aria-label="Navegação Principal">
                <a href="index.html" class="nav-link">Início</a>
                <a href="pokemon.html" class="nav-link">Pokémon Disponíveis</a>
                <a href="como-adotar.html" class="nav-link ativo" aria-current="page">Como Adotar</a>
                <a href="sobre.html" class="nav-link">Sobre Nós</a>
                <a href="login.html" class="nav-link nav-destaque">Login</a>
            </nav>

            <!-- Contato Rápido -->
            <div id="contato-rapido">
                <a href="https://wa.me/5511941984860" target="_blank" rel="noopener noreferrer" title="Falar no WhatsApp">(11) 94198-4860</a>
            </div>
        </div>

        <!-- Linha Divisória com Pokébola Interativa -->
        <div id="linha">
            <button id="bola" onclick="alert('Pronto para adotar seu novo companheiro? Siga os passos abaixo!')" title="Clique para uma surpresa" type="button">
                <img src="img/botao_pokebola.png" alt="Pokébola Interativa" width="58" height="58">
            </button>
        </div>
    </header>

    <!-- CONTEÚDO PRINCIPAL DA PÁGINA -->
    <main>
        <!-- Banner Interno Padrão -->
        <section class="pagina-cabecalho">
            <div class="container">
                <span class="badge-tag">📋 Guia do Adotante</span>
                <h2>Como Funciona o Processo de Adoção</h2>
                <p>Adotar um Pokémon é um ato de amor e responsabilidade. Conheça as etapas para garantir uma convivência feliz e segura.</p>
            </div>
        </section>

        <!-- Container do Conteúdo Geral -->
        <section class="pagina-conteudo">
            <div class="container">

                <!-- Passo a Passo (Lista Ordenada Semântica) -->
                <article class="card-sobre mb-4">
                    <div class="titulo-secao">
                        <h2>Passo a Passo para a Adoção</h2>
                        <p>O processo foi desenhado para encontrar o par perfeito entre você e o Pokémon!</p>
                    </div>

                    <ol class="lista-passos">
                        <li class="passo-item">
                            <div class="passo-numero">1</div>
                            <div class="passo-conteudo">
                                <h3>Escolha o Pokémon e Conheça o Perfil</h3>
                                <p>Navegue pela nossa página de <a href="pokemon.html" class="link-destaque">Pokémon Disponíveis</a>. Confira o tipo, temperamento, habitat recomendado e necessidades específicas de cada um.</p>
                            </div>
                        </li>

                        <li class="passo-item">
                            <div class="passo-numero">2</div>
                            <div class="passo-conteudo">
                                <h3>Preencha a Ficha de Intenção</h3>
                                <p>Faça o <a href="login.html" class="link-destaque">login na sua conta</a> de treinador e envie o formulário de interesse declarando seu espaço físico, rotina diária e experiência com a espécie.</p>
                            </div>
                        </li>

                        <li class="passo-item">
                            <div class="passo-numero">3</div>
                            <div class="passo-conteudo">
                                <h3>Entrevista e Triagem com Especialista</h3>
                                <p>Nossa equipe veterinária e de comportamentistas agendará uma conversa virtual ou presencial para tirar dúvidas e avaliar a compatibilidade do lar.</p>
                            </div>
                        </li>

                        <li class="passo-item">
                            <div class="passo-numero">4</div>
                            <div class="passo-conteudo">
                                <h3>Encontro de Adaptação e Assinatura</h3>
                                <p>Você visitará a sede do PokéLar para o primeiro contato direto. Estando tudo certo, o Termo de Adoção Responsável é assinado e vocês voltam juntos para casa!</p>
                            </div>
                        </li>
                    </ol>
                </article>

                <!-- Requisitos e Critérios -->
                <div class="impacto-grid mb-4">
                    <article class="card-ajuda">
                        <div>
                            <span class="icone-pilar">📜</span>
                            <h3>Requisitos Básicos</h3>
                            <ul class="lista-requisitos">
                                <li>Possuir Licença de Treinador ativa ou ser maior de 18 anos.</li>
                                <li>Documento de identidade (RG/CPF) e comprovante de residência.</li>
                                <li>Autorização de todos os moradores da residência.</li>
                            </ul>
                        </div>
                    </article>

                    <article class="card-ajuda">
                        <div>
                            <span class="icone-pilar">🏡</span>
                            <h3>Espaço e Estrutura</h3>
                            <ul class="lista-requisitos">
                                <li>Ambiente seguro e protegido de fuga ou acidentes.</li>
                                <li>Espaço compatível com a tipagem (ex: área molhada para aquáticos).</li>
                                <li>Área para descanso limpa e coberta.</li>
                            </ul>
                        </div>
                    </article>

                    <article class="card-ajuda">
                        <div>
                            <span class="icone-pilar">❤️</span>
                            <h3>Compromisso Contínuo</h3>
                            <ul class="lista-requisitos">
                                <li>Alimentação diária adequada e fornecimento de Berries.</li>
                                <li>Acompanhamento médico veterinário em Centros Pokémon.</li>
                                <li>NUNCA utilizar o resgatado em batalhas clandestinas.</li>
                            </ul>
                        </div>
                    </article>
                </div>

                <!-- Call to Action -->
                <div class="cta-box">
                    <h3>Pronto para dar o primeiro passo?</h3>
                    <p>Conheça os Pokémon resgatados que estão aguardando um lar cheio de carinho em Kanto.</p>
                    <div class="cta-botoes">
                        <a href="pokemon.html" class="btn-cta-primario">Ver Pokémon Disponíveis</a>
                        <a href="https://wa.me/5511941984860" target="_blank" rel="noopener noreferrer" class="btn-cta-secundario">Tirar Dúvidas no WhatsApp</a>
                    </div>
                </div>

            </div>
        </section>
    </main>

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