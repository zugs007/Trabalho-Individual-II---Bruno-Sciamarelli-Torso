<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login do Treinador - PokéLar</title>
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
                <a href="como-adotar.html" class="nav-link">Como Adotar</a>
                <a href="sobre.html" class="nav-link">Sobre Nós</a>
                <a href="login.html" class="nav-link nav-destaque ativo" aria-current="page">Login</a>
            </nav>

            <!-- Contato Rápido -->
            <div id="contato-rapido">
                <a href="https://wa.me/5511941984860" target="_blank" rel="noopener noreferrer" title="Falar no WhatsApp">(11) 94198-4860</a>
            </div>
        </div>

        <!-- Linha Divisória com Pokébola Interativa -->
        <div id="linha">
            <button id="bola" onclick="alert('Área restrita para treinadores cadastrados!')" title="Clique para uma surpresa" type="button">
                <img src="img/botao_pokebola.png" alt="Pokébola Interativa" width="58" height="58">
            </button>
        </div>
    </header>

    <!-- CONTEÚDO PRINCIPAL DA PÁGINA -->
    <main>
        <!-- Banner Interno Padrão -->
        <section class="pagina-cabecalho">
            <div class="container">
                <span class="badge-tag">🔑 Área do Treinador</span>
                <h2>Acesse sua Conta</h2>
                <p>Acompanhe seus pedidos de adoção, atualize seus dados e gerencie suas visitas ao PokéLar.</p>
            </div>
        </section>

        <!-- Container do Formulário de Login -->
        <section class="pagina-conteudo">
            <div class="container container-login">
                
                <div class="card-form-login">
                    <div class="form-cabecalho">
                        <h3>Entrar no PokéLar</h3>
                        <p>Digite suas credenciais de treinador para continuar.</p>
                    </div>

                    <form action="#" method="post" class="form-login">
                        <div class="campo-grupo">
                            <label for="email-login">E-mail ou ID de Treinador</label>
                            <input 
                                type="email" 
                                id="email-login" 
                                name="email" 
                                placeholder="exemplo@pokemail.com" 
                                required 
                                autocomplete="email"
                            >
                        </div>

                        <div class="campo-grupo">
                            <div class="rotulo-com-link">
                                <label for="senha-login">Senha</label>
                                <a href="#" class="link-esqueceu-senha">Esqueceu a senha?</a>
                            </div>
                            <input 
                                type="password" 
                                id="senha-login" 
                                name="senha" 
                                placeholder="••••••••" 
                                required 
                                minlength="6"
                                autocomplete="current-password"
                            >
                        </div>

                        <div class="campo-checkbox">
                            <input type="checkbox" id="lembrar-me" name="lembrar">
                            <label for="lembrar-me">Lembrar de mim neste dispositivo</label>
                        </div>

                        <button type="submit" class="btn-login-submeter">Acessar Conta</button>
                    </form>

                    <div class="form-rodape-opcao">
                        <p>Ainda não tem uma conta de treinador? <a href="#" class="link-destaque">Cadastre-se aqui</a></p>
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