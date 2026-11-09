<?php
require_once 'config/database.php';
require_once 'src/Auth.php';
require_once 'src/Csrf.php';
require_once 'src/Logger.php';

// Exige que o usuário esteja logado
Auth::requireLogin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token      = $_POST['csrf_token'] ?? '';
    $pokemon_id = (int)($_POST['pokemon_id'] ?? 0);

    if (!Csrf::validateToken($token)) {
        header('Location: pokemon.php?erro=csrf');
        exit;
    }

    if ($pokemon_id > 0) {
        // Verifica se o Pokémon ainda está disponível
        $stmt = $pdo->prepare("SELECT id, nome, status FROM pokemons WHERE id = :id");
        $stmt->execute([':id' => $pokemon_id]);
        $pokemon = $stmt->fetch();

        if ($pokemon && $pokemon['status'] === 'disponivel') {
            // Altera o status para 'em-processo' (Reserva efetuada)
            $update = $pdo->prepare("UPDATE pokemons SET status = 'em-processo' WHERE id = :id");
            $update->execute([':id' => $pokemon_id]);

            Logger::log(
                "Solicitação de adoção efetuada: Pokémon {$pokemon['nome']} (#{$pokemon_id}) reservado pelo treinador {$_SESSION['usuario_email']}", 
                "INFO"
            );

            header('Location: minha-conta.php?msg=adocao_solicitada&pokemon=' . urlencode($pokemon['nome']));
            exit;
        }
    }
}

header('Location: pokemon.php');
exit;