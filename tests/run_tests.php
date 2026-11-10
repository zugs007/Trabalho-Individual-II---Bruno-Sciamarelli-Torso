<?php
// tests/run_tests.php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../src/Auth.php';
require_once __DIR__ . '/../src/Csrf.php';

echo "====================================================\n";
echo "   POKÉLAR - SUÍTE DE TESTES AUTOMATIZADOS (CLI)    \n";
echo "====================================================\n\n";

$passou = 0;
$falhou = 0;

function assercao($nomeTeste, $condicao) {
    global $passou, $falhou;
    if ($condicao) {
        echo "[ PASS ] {$nomeTeste}\n";
        $passou++;
    } else {
        echo "[ FAIL ] {$nomeTeste}\n";
        $falhou++;
    }
}

$token = Csrf::generateToken();
assercao("T01: Gerar e validar Token CSRF válido", Csrf::validateToken($token));

assercao("T02: Rejeitar Token CSRF forjado/inválido", !Csrf::validateToken("token_falso_12345"));

assercao("T03: Conexão ativa com o banco de dados via PDO", $pdo instanceof PDO);

$hash = password_hash("senhaTeste123", PASSWORD_BCRYPT);
assercao("T04: Validação de Hash BCrypt de senha", password_verify("senhaTeste123", $hash));

assercao("T05: Rejeitar verificação de senha incorreta", !password_verify("senhaErrada", $hash));

echo "\n----------------------------------------------------\n";
echo "RESULTADO FINAL: {$passou} Aprovados | {$falhou} Falhas\n";
echo "====================================================\n";