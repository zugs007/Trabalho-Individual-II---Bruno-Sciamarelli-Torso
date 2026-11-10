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

    // Exige login simples (Cliente ou Admin)
    public static function requireLogin() {
        if (!self::check()) {
            // Detecta se a requisição veio de dentro da pasta /admin/ para ajustar o caminho relativo
            $prefixo = (strpos($_SERVER['PHP_SELF'], '/admin/') !== false) ? '../' : '';
            header("Location: {$prefixo}login.php?erro=acesso_negado");
            exit;
        }
    }

    // Exige perfil estrito de Administrador
    public static function requireAdmin() {
        if (!self::isAdmin()) {
            // Detecta se a requisição veio de dentro da pasta /admin/ para ajustar o caminho relativo
            $prefixo = (strpos($_SERVER['PHP_SELF'], '/admin/') !== false) ? '../' : '';
            header("Location: {$prefixo}login.php?erro=acesso_negado");
            exit;
        }
    }
}