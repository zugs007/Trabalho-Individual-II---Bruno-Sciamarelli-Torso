<?php

require_once __DIR__ . '/Logger.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class Auth {
    
    public static function login($email, $senha, $pdo) {
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email");
        $stmt->execute([':email' => $email]);
        $usuario = $stmt->fetch();

        if ($usuario && password_verify($senha, $usuario['senha'])) {
            // Regenera o ID de sessão por segurança
            session_regenerate_id(true);

            $_SESSION['usuario_id']     = $usuario['id'];
            $_SESSION['usuario_nome']   = $usuario['nome'];
            $_SESSION['usuario_email']  = $usuario['email'];
            $_SESSION['usuario_perfil'] = $usuario['perfil'];

            Logger::log("Login bem-sucedido: {$usuario['email']} (Perfil: {$usuario['perfil']})", "INFO");
            return true;
        }

        Logger::log("Falha de autenticação para o e-mail: {$email}", "WARNING");
        return false;
    }

    public static function check() {
        return isset($_SESSION['usuario_id']);
    }

    public static function isAdmin() {
        return self::check() && $_SESSION['usuario_perfil'] === 'admin';
    }

    public static function requireLogin() {
        if (!self::check()) {
            header('Location: login.php?erro=acesso_negado');
            exit;
        }
    }

    public static function requireAdmin() {
        self::requireLogin();
        if (!self::isAdmin()) {
            header('Location: index.php?erro=permissao_insuficiente');
            exit;
        }
    }

    public static function logout() {
        if (isset($_SESSION['usuario_email'])) {
            Logger::log("Logout efetuado: {$_SESSION['usuario_email']}", "INFO");
        }
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
    }
}