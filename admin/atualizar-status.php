<?php
require_once '../config/database.php';
require_once '../src/Auth.php';
require_once '../src/Csrf.php';
require_once '../src/Logger.php';

Auth::requireAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token  =$_POST['csrf_token'] ?? '';
    $id     = (int)($_POST['id'] ?? 0);
    $status = trim($_POST['status'] ?? '');

    $statusValidos = ['disponivel', 'em-processo', 'adotado'];

    if (!Csrf::validateToken($token)) {
        header('Location: index.php?erro=csrf');
        exit;
    }

    if ($id > 0 && in_array($status,$statusValidos, true)) {
        // Busca o nome do Pokémon para registrar no log de auditoria
        $stmtName =$pdo->prepare("SELECT nome FROM pokemons WHERE id = :id");
        $stmtName->execute([':id' =>$id]);
        $poke =$stmtName->fetch();

        // Atualiza o status no banco de dados
        $stmt =$pdo->prepare("UPDATE pokemons SET status = :status WHERE id = :id");
        $stmt->execute([':status' => $status, ':id' =>$id]);

        $nomePoke =$poke ? $poke['nome'] : "ID #{$id}";
        Logger::log("Status do Pokémon {$nomePoke} (ID: {$id}) alterado para '{$status}' por {$_SESSION['usuario_email']}", "INFO");

        header('Location: index.php?msg=status_atualizado');
        exit;
    }
}

header('Location: index.php');
exit;