<?php
require_once '../config/database.php';
require_once '../src/Auth.php';
require_once '../src/Logger.php';

Auth::requireAdmin();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    // Busca nome para registrar no log antes de remover
    $stmt = $pdo->prepare("SELECT nome FROM pokemons WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $poke = $stmt->fetch();

    if ($poke) {
        $del = $pdo->prepare("DELETE FROM pokemons WHERE id = :id");
        $del->execute([':id' => $id]);

        Logger::log("Pokémon removido: {$poke['nome']} (ID: {$id}) pelo admin " . $_SESSION['usuario_email'], "WARNING");
        header('Location: index.php?msg=removido');
        exit;
    }
}

header('Location: index.php?erro=nao_encontrado');
exit;