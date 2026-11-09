<?php
require_once '../config/database.php';
require_once '../src/Auth.php';
require_once '../src/Csrf.php';
require_once '../src/Logger.php';

Auth::requireAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token  = $_POST['csrf_token'] ?? '';
    $id     = (int)($_POST['id'] ?? 0);
    $status = trim($_POST['status'] ?? '');

    $statusValidos = ['em_analise', 'confirmado', 'concluido', 'cancelado'];

    if (!Csrf::validateToken($token)) {
        header('Location: adocoes.php?erro=csrf');
        exit;
    }

    if ($id > 0 && in_array($status, $statusValidos, true)) {
        // Atualiza o status na tabela adocoes
        $stmt = $pdo->prepare("UPDATE adocoes SET status = :status WHERE id = :id");
        $stmt->execute([':status' => $status, ':id' => $id]);

        // Se o agendamento foi marcado como concluído, atualiza o Pokémon para 'adotado'
        if ($status === 'concluido') {
            $stmtAdocao = $pdo->prepare("SELECT pokemon_id FROM adocoes WHERE id = :id");
            $stmtAdocao->execute([':id' => $id]);
            $adocao = $stmtAdocao->fetch();

            if ($adocao) {
                $updatePoke = $pdo->prepare("UPDATE pokemons SET status = 'adotado' WHERE id = :pid");
                $updatePoke->execute([':pid' => $adocao['pokemon_id']]);
            }
        }

        Logger::log("Agendamento #{$id} atualizado para status '{$status}' pelo admin {$_SESSION['usuario_email']}", "INFO");

        header('Location: adocoes.php?msg=status_atualizado');
        exit;
    }
}

header('Location: adocoes.php');
exit;