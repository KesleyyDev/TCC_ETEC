<?php
require_once "../config.php";
require_once DBAPI;
if (!isset($_SESSION)) session_start();
include(HEADER_TEMPLATE);

// =============================================
// SEGURANÇA: Token CSRF
// =============================================
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// =============================================
// LÓGICA DE LOGIN
// =============================================
$erro = '';
$sucesso = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 1. Verificar token CSRF
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        $erro = 'Erro de segurança. Recarregue a página e tente novamente.';
    } else {
        // 2. Rate limiting básico por sessão
        $max_tentativas = 5;
        $bloqueio_segundos = 120;

        if (!isset($_SESSION['login_tentativas'])) {
            $_SESSION['login_tentativas'] = 0;
            $_SESSION['login_ultimo_erro'] = 0;
        }

        if ($_SESSION['login_tentativas'] >= $max_tentativas) {
            $tempo_restante = $bloqueio_segundos - (time() - $_SESSION['login_ultimo_erro']);
            if ($tempo_restante > 0) {
                $erro = 'Muitas tentativas. Aguarde ' . ceil($tempo_restante) . ' segundos antes de tentar novamente.';
            } else {
                $_SESSION['login_tentativas'] = 0;
            }
        }

        if (empty($erro)) {
            // 3. Sanitizar e validar entradas
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $senha = $_POST['senha'] ?? '';

            if (empty($email) || empty($senha)) {
                $erro = 'Preencha todos os campos.';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $erro = 'Informe um e-mail válido.';
            } elseif (strlen($senha) < 6) {
                $erro = 'A senha deve ter no mínimo 6 caracteres.';
            } else {
                // 4. Autenticação com prepared statements (proteção contra SQL Injection)
                try {
                    $pdo = new PDO(DB_DSN, DB_USER, DB_PASS, [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                    ]);

                    $stmt = $pdo->prepare("SELECT id, nome, email, senha, rule FROM usuarios WHERE email = :email LIMIT 1");
                    $stmt->execute([':email' => $email]);
                    $usuario = $stmt->fetch();

                    if ($usuario && password_verify($senha, $usuario['senha'])) {
                        // Login bem-sucedido
                        session_regenerate_id(true); // Previne session fixation

                        unset($_SESSION['login_tentativas']);
                        unset($_SESSION['login_ultimo_erro']);

                        $_SESSION['usuario_id'] = $usuario['id'];
                        $_SESSION['usuario_nome'] = $usuario['nome'];
                        $_SESSION['usuario_email'] = $usuario['email'];
                        $_SESSION['usuario_rule'] = $usuario['rule'];
                        $_SESSION['logado'] = true;

                        // Gerar novo token CSRF após login
                        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

                        header('Location: ' . BASEURL . 'gestao/gestao.php');
                        exit;
                    } else {
                        $_SESSION['login_tentativas']++;
                        $_SESSION['login_ultimo_erro'] = time();
                        $erro = 'E-mail ou senha incorretos.';
                    }
                } catch (PDOException $e) {
                    $erro = 'Erro ao conectar ao servidor. Tente novamente mais tarde.';
                }
            }
        }
    }

    // Regenerar token CSRF após o POST
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>

<div class="container py-5 fade-in">
    <div class="row justify-content-center align-items-center" style="min-height: 70vh;">
        <div class="col-sm-10 col-md-8 col-lg-5 col-xl-4">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <!-- Header do Card -->
                <div class="p-4 text-center" style="background-color: var(--header-escuro);">
                    <i class="fa-solid fa-user-lock fa-3x mb-3" style="color: var(--fundo-creme);"></i>
                    <h3 class="fw-bold mb-1" style="color: var(--fundo-creme);">Área Restrita</h3>
                    <p class="mb-0" style="color: var(--logo-claro); font-size: 0.9rem;">Acesse o painel de gerenciamento</p>
                </div>

                <!-- Body do Card -->
                <div class="card-body p-4 p-md-5" style="background-color: #fff;">

                    <?php if (!empty($erro)): ?>
                        <div class="alert alert-danger d-flex align-items-center rounded-3 mb-4" role="alert">
                            <i class="fa-solid fa-circle-exclamation me-2"></i>
                            <div><?php echo htmlspecialchars($erro, ENT_QUOTES, 'UTF-8'); ?></div>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($sucesso)): ?>
                        <div class="alert alert-success d-flex align-items-center rounded-3 mb-4" role="alert">
                            <i class="fa-solid fa-circle-check me-2"></i>
                            <div><?php echo htmlspecialchars($sucesso, ENT_QUOTES, 'UTF-8'); ?></div>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="<?php echo BASEURL; ?>paginas/login.php" novalidate>
                        <!-- Token CSRF -->
                        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>">

                        <!-- E-mail -->
                        <div class="mb-4">
                            <label for="email" class="form-label fw-semibold" style="color: var(--logo-escuro);">
                                <i class="fa-solid fa-envelope me-1"></i> E-mail
                            </label>
                            <input
                                type="email"
                                class="form-control form-control-lg rounded-3"
                                id="email"
                                name="email"
                                placeholder="seunome@email.com"
                                required
                                autocomplete="email"
                                value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8') : ''; ?>"
                                style="border-color: var(--logo-claro);"
                            >
                        </div>

                        <!-- Senha -->
                        <div class="mb-4">
                            <label for="senha" class="form-label fw-semibold" style="color: var(--logo-escuro);">
                                <i class="fa-solid fa-lock me-1"></i> Senha
                            </label>
                            <div class="input-group">
                                <input
                                    type="password"
                                    class="form-control form-control-lg rounded-start-3"
                                    id="senha"
                                    name="senha"
                                    placeholder="Digite sua senha"
                                    required
                                    autocomplete="current-password"
                                    minlength="6"
                                    style="border-color: var(--logo-claro);"
                                >
                                <button
                                    class="btn btn-outline-secondary rounded-end-3"
                                    type="button"
                                    id="toggleSenha"
                                    title="Mostrar/ocultar senha"
                                    style="border-color: var(--logo-claro); color: var(--logo-escuro);"
                                >
                                    <i class="fa-solid fa-eye" id="toggleSenhaIcon"></i>
                                </button>
                            </div>
                            <div class="form-text" style="color: var(--logo-medio);">
                                Mínimo de 6 caracteres.
                            </div>
                        </div>

                        <!-- Lembrar-me -->
                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" id="lembrar" name="lembrar" value="1">
                            <label class="form-check-label" for="lembrar" style="color: var(--logo-escuro);">
                                Lembrar-me neste dispositivo
                            </label>
                        </div>

                        <!-- Botão de Login -->
                        <div class="d-grid mb-4">
                            <button type="submit" class="btn btn-nanias btn-lg rounded-3 fw-bold">
                                <i class="fa-solid fa-right-to-bracket me-2"></i>Entrar
                            </button>
                        </div>
                    </form>

                    <!-- Separador -->
                    <div class="d-flex align-items-center mb-4">
                        <hr class="flex-grow-1" style="border-color: var(--logo-claro); opacity: 0.3;">
                        <span class="px-3 small fw-semibold" style="color: var(--logo-medio);">ou</span>
                        <hr class="flex-grow-1" style="border-color: var(--logo-claro); opacity: 0.3;">
                    </div>

                    <!-- Link para suporte -->
                    <div class="text-center">
                        <p class="mb-0 small" style="color: var(--logo-medio);">
                            Problemas para acessar?
                            <a href="<?php echo BASEURL; ?>paginas/suporte.php" class="fw-semibold" style="color: var(--botao-escuro); text-decoration: none;">
                                Fale com o suporte
                            </a>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Voltar ao início -->
            <div class="text-center mt-4">
                <a href="<?php echo BASEURL; ?>index.php" class="text-decoration-none fw-semibold" style="color: var(--logo-escuro);">
                    <i class="fa-solid fa-arrow-left me-1"></i> Voltar ao início
                </a>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Toggle mostrar/ocultar senha
    var toggleBtn = document.getElementById('toggleSenha');
    var senhaInput = document.getElementById('senha');
    var toggleIcon = document.getElementById('toggleSenhaIcon');

    if (toggleBtn && senhaInput && toggleIcon) {
        toggleBtn.addEventListener('click', function () {
            var isPassword = senhaInput.type === 'password';
            senhaInput.type = isPassword ? 'text' : 'password';
            toggleIcon.classList.toggle('fa-eye');
            toggleIcon.classList.toggle('fa-eye-slash');
        });
    }
});
</script>

<?php 
include(FOOTER_TEMPLATE);
?>