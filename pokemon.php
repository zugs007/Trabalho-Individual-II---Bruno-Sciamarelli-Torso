<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokémon Disponíveis - PokéLar</title>
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
                <a href="pokemon.html" class="nav-link ativo" aria-current="page">Pokémon Disponíveis</a>
                <a href="como-adotar.html" class="nav-link">Como Adotar</a>
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
            <button id="bola" onclick="alert('Conheça nossos companheiros em busca de um lar!')" title="Clique para uma surpresa" type="button">
                <img src="img/botao_pokebola.png" alt="Pokébola Interativa" width="58" height="58">
            </button>
        </div>
    </header>

    <!-- CONTEÚDO PRINCIPAL DA PÁGINA -->
    <main>
        <!-- Banner Interno Padrão -->
        <section class="pagina-cabecalho">
            <div class="container">
                <span class="badge-tag">🐾 Nossos Resgatados</span>
                <h2>Pokémon Disponíveis para Adoção</h2>
                <p>Conheça os Pokémon que estão sob os cuidados do PokéLar aguardando por uma nova família e um lar amoroso.</p>
            </div>
        </section>

        <!-- Container de Conteúdo -->
        <div class="pagina-conteudo">
            <div class="container">

                <!-- Barra de Filtros e Busca -->
                <div class="painel-filtros mb-4">
                    <form action="#" method="get" class="form-filtros" role="search">
                        <div class="campo-filtro">
                            <label for="busca-nome">Buscar por nome:</label>
                            <input type="search" id="busca-nome" name="nome" placeholder="Ex: Bulbasaur, Pikachu...">
                        </div>

                        <div class="campo-filtro">
                            <label for="filtro-tipo">Tipo:</label>
                            <select id="filtro-tipo" name="tipo">
                                <option value="">Todos os tipos</option>
                                <option value="planta">Planta</option>
                                <option value="fogo">Fogo</option>
                                <option value="agua">Água</option>
                                <option value="eletrico">Elétrico</option>
                                <option value="normal">Normal</option>
                            </select>
                        </div>

                        <div class="campo-filtro">
                            <label for="filtro-porte">Porte:</label>
                            <select id="filtro-porte" name="porte">
                                <option value="">Todos os portes</option>
                                <option value="pequeno">Pequeno</option>
                                <option value="medio">Médio</option>
                                <option value="grande">Grande</option>
                            </select>
                        </div>

                        <button type="submit" class="btn-filtrar">Filtrar</button>
                    </form>
                </div>

                <!-- Grade de Cards de Pokémon -->
                <div class="grid-pokemon">

                    <!-- Card 1: Bulbasaur -->
                    <article class="card-pokemon">
                        <div class="card-pokemon-imagem">
                            <span class="badge-status disponivel">Disponível</span>
                            <img src="img/bulbasaur.png" alt="Bulbasaur sorrindo com um bulbo verde nas costas" width="280" height="200" loading="lazy">
                        </div>
                        <div class="card-pokemon-corpo">
                            <div class="tags-tipo">
                                <span class="tag-tipo tipo-planta">Planta</span>
                                <span class="tag-tipo tipo-veneno">Veneno</span>
                            </div>
                            <h3>Bulbasaur</h3>
                            <ul class="info-caracteristicas">
                                <li><strong>Idade:</strong> Jovem (2 anos)</li>
                                <li><strong>Temperamento:</strong> Calmo e afetuoso</li>
                                <li><strong>Local de Resgate:</strong> Floresta de Viridian</li>
                            </ul>
                            <p class="descricao-resumida">Muito dócil e adora tomar sol no jardim. Ideal para treinadores iniciantes ou famílias com crianças.</p>
                            <div class="card-pokemon-acoes">
                                <a href="como-adotar.html" class="btn-card-adotar">Quero Adotar</a>
                            </div>
                        </div>
                    </article>

                    <!-- Card 2: Charmander -->
                    <article class="card-pokemon">
                        <div class="card-pokemon-imagem">
                            <span class="badge-status disponivel">Disponível</span>
                            <img src="img/charmander.png" alt="Charmander alegre com a chama da cauda acesa" width="280" height="200" loading="lazy">
                        </div>
                        <div class="card-pokemon-corpo">
                            <div class="tags-tipo">
                                <span class="tag-tipo tipo-fogo">Fogo</span>
                            </div>
                            <h3>Charmander</h3>
                            <ul class="info-caracteristicas">
                                <li><strong>Idade:</strong> Filhote (1 ano)</li>
                                <li><strong>Temperamento:</strong> Leal e enérgico</li>
                                <li><strong>Local de Resgate:</strong> Rota 24 (Sob chuva)</li>
                            </ul>
                            <p class="descricao-resumida">Resgatado em dia de tempestade, hoje está saudável, cheio de energia e adora brincar perto de lareiras.</p>
                            <div class="card-pokemon-acoes">
                                <a href="como-adotar.html" class="btn-card-adotar">Quero Adotar</a>
                            </div>
                        </div>
                    </article>

                    <!-- Card 3: Squirtle -->
                    <article class="card-pokemon">
                        <div class="card-pokemon-imagem">
                            <span class="badge-status em-processo">Em Adoção</span>
                            <img src="img/squirtle.png" alt="Squirtle acenando com a patinha" width="280" height="200" loading="lazy">
                        </div>
                        <div class="card-pokemon-corpo">
                            <div class="tags-tipo">
                                <span class="tag-tipo tipo-agua">Água</span>
                            </div>
                            <h3>Squirtle</h3>
                            <ul class="info-caracteristicas">
                                <li><strong>Idade:</strong> Jovem (2 anos)</li>
                                <li><strong>Temperamento:</strong> Brincalhão e protetor</li>
                                <li><strong>Local de Resgate:</strong> Praia de Vermilion</li>
                            </ul>
                            <p class="descricao-resumida">Adora nadar em tanques e lagos. Atualmente em processo de entrevista com uma nova família.</p>
                            <div class="card-pokemon-acoes">
                                <span class="btn-card-adotar desabilitado">Em Análise</span>
                            </div>
                        </div>
                    </article>

                    <!-- Card 4: Pikachu -->
                    <article class="card-pokemon">
                        <div class="card-pokemon-imagem">
                            <span class="badge-status disponivel">Disponível</span>
                            <img src="img/pikachu.png" alt="Pikachu sorridente com bochechas vermelhas" width="280" height="200" loading="lazy">
                        </div>
                        <div class="card-pokemon-corpo">
                            <div class="tags-tipo">
                                <span class="tag-tipo tipo-eletrico">Elétrico</span>
                            </div>
                            <h3>Pikachu</h3>
                            <ul class="info-caracteristicas">
                                <li><strong>Idade:</strong> Adulto (3 anos)</li>
                                <li><strong>Temperamento:</strong> Curioso e carinhoso</li>
                                <li><strong>Local de Resgate:</strong> Usina de Power Plant</li>
                            </ul>
                            <p class="descricao-resumida">Gosta de ficar nos ombros do tutor. Precisa de brinquedos para descarregar o excesso de eletricidade acumulada.</p>
                            <div class="card-pokemon-acoes">
                                <a href="como-adotar.html" class="btn-card-adotar">Quero Adotar</a>
                            </div>
                        </div>
                    </article>

                    <!-- Card 5: Eevee -->
                    <article class="card-pokemon">
                        <div class="card-pokemon-imagem">
                            <span class="badge-status disponivel">Disponível</span>
                            <img src="img/eevee.png" alt="Eevee sentado olhando para frente" width="280" height="200" loading="lazy">
                        </div>
                        <div class="card-pokemon-corpo">
                            <div class="tags-tipo">
                                <span class="tag-tipo tipo-normal">Normal</span>
                            </div>
                            <h3>Eevee</h3>
                            <ul class="info-caracteristicas">
                                <li><strong>Idade:</strong> Filhote (8 meses)</li>
                                <li><strong>Temperamento:</strong> Adaptável e muito dócil</li>
                                <li><strong>Local de Resgate:</strong> Cidade de Celadon</li>
                            </ul>
                            <p class="descricao-resumida">Muito carinhoso e interativo. Adapta-se facilmente a apartamentos e convivência com outros Pokémon.</p>
                            <div class="card-pokemon-acoes">
                                <a href="como-adotar.html" class="btn-card-adotar">Quero Adotar</a>
                            </div>
                        </div>
                    </article>

                    <!-- Card 6: Snorlax -->
                    <article class="card-pokemon">
                        <div class="card-pokemon-imagem">
                            <span class="badge-status disponivel">Disponível</span>
                            <img src="img/snorlax.png" alt="Snorlax dormindo de barriga para cima" width="280" height="200" loading="lazy">
                        </div>
                        <div class="card-pokemon-corpo">
                            <div class="tags-tipo">
                                <span class="tag-tipo tipo-normal">Normal</span>
                            </div>
                            <h3>Snorlax</h3>
                            <ul class="info-caracteristicas">
                                <li><strong>Idade:</strong> Adulto (6 anos)</li>
                                <li><strong>Temperamento:</strong> Pacato e dorminhoco</li>
                                <li><strong>Local de Resgate:</strong> Rota 12 (Bloqueando passagem)</li>
                            </ul>
                            <p class="descricao-resumida">Necessita de um quintal espaçoso e rotina diária de alimentação supervisionada por nutricionista veterinário.</p>
                            <div class="card-pokemon-acoes">
                                <a href="como-adotar.html" class="btn-card-adotar">Quero Adotar</a>
                            </div>
                        </div>
                    </article>

                </div>

            </div>
        </div>
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