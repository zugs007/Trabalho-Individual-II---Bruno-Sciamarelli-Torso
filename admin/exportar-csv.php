<?php
require_once '../config/database.php';
require_once '../src/Auth.php';

Auth::requireAdmin();

// Define os cabeçalhos de resposta HTTP para força o download do CSV
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=relatorio_adocoes_' . date('Y-m-d') . '.csv');

// Abre o fluxo de saída do PHP
$output = fopen('php://output', 'w');

// Insere o BOM (Byte Order Mark) para garantir caracteres em UTF-8 no Microsoft Excel
fputs($output, chr(0xEF) . chr(0xBB) . chr(0xBF));

// Cabeçalhos das colunas
fputcsv($output, ['ID Agendamento', 'Nome Cliente', 'Email Cliente', 'Pokemon', 'Data Visita', 'Hora Visita', 'Status', 'Data Criacao']);

// Consulta os agendamentos no banco
$stmt = $pdo->query("
    SELECT a.id, u.nome AS cliente, u.email, p.nome AS pokemon, a.data_visita, a.hora_visita, a.status, a.criado_em
    FROM adocoes a
    JOIN usuarios u ON a.usuario_id = u.id
    JOIN pokemons p ON a.pokemon_id = p.id
    ORDER BY a.id DESC
");

while ($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {
    fputcsv($output, $linha);
}

fclose($output);
exit;