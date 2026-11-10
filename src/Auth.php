<?php
// src/Auth.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class Auth {

    // Verifica se existe algum usuário logado na sessão
    public static function check() {
        return isset($_SESSION['usuario_id']);
    }

    // Verifica se o usuário logado tem perfil de administrador
    public static function isAdmin() {
        return self::check() && isset($_SESSION['usuario_perfil']) && $_SESSION['usuario_perfil'] === 'admin';
    }

    // Processa a autenticação: consulta o e-mail, valida a senha com BCrypt e grava a sessão
    public static function login($email, $senha, $pdo) {
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $usuario = $stmt->fetch();

        if ($usuario && password_verify($senha, $usuario['senha'])) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['usuario_id']     = $usuario['id'];
            $_SESSION['usuario_nome']   = $usuario['nome'];
            $_SESSION['usuario_email']  = $usuario['email'];
            $_SESSION['usuario_perfil'] = $usuario['perfil'];
            return true;
        }

        return false;
    }

    // Destrói e limpa a sessão do usuário
    public static function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
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

    // Exige login simples (Cliente ou Admin)
    public static function requireLogin() {
        if (!self::check()) {
            $prefixo = (strpos($_SERVER['PHP_SELF'], '/admin/') !== false) ? '../' : '';
            header("Location: {$prefixo}login.php?erro=acesso_negado");
            exit;
        }
    }

    // Exige perfil estrito de Administrador
    public static function requireAdmin() {
        if (!self::isAdmin()) {
            $prefixo = (strpos($_SERVER['PHP_SELF'], '/admin/') !== false) ? '../' : '';
            header("Location: {$prefixo}login.php?erro=acesso_negado");
            exit;
        }
    }
}