<?php

/** Redireciona visitantes não autenticados para a tela de login. */
function require_login(): void
{
    if (empty($_SESSION['logado']) || $_SESSION['logado'] !== true || empty($_SESSION['usuario_id'])) {
        header('Location: ' . BASEURL . 'paginas/login.php');
        exit;
    }
}

/** Garante que o usuário autenticado tenha uma das funções informadas. */
function require_roles(array $roles): void
{
    require_login();

    $currentRole = $_SESSION['usuario_rule'] ?? null;
    if (!is_string($currentRole) || !in_array($currentRole, $roles, true)) {
        header('Location: ' . BASEURL . 'index.php?erro=acesso_negado');
        exit;
    }
}

/** Retorna o token CSRF da sessão, criando-o quando necessário. */
function csrf_token(): string
{
    if (empty($_SESSION['csrf_token']) || !is_string($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

/** Campo HTML reutilizável para formulários protegidos. */
function csrf_field(): string
{
    return '<input type="hidden" name="csrf_token" value="' .
        htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8') . '">';
}

/** Verifica um token CSRF sem produzir mensagens técnicas para o usuário. */
function valid_csrf_token(?string $token): bool
{
    $sessionToken = $_SESSION['csrf_token'] ?? '';
    return is_string($sessionToken) && $sessionToken !== '' &&
        is_string($token) && hash_equals($sessionToken, $token);
}

/** Encerra requisições POST sem o token CSRF correto. */
function require_csrf(): void
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST' ||
        !valid_csrf_token($_POST['csrf_token'] ?? null)) {
        http_response_code(403);
        exit('Requisição inválida. Recarregue a página e tente novamente.');
    }
}

