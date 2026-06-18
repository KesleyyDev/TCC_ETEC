<?php
require_once "../config.php";
require_once DBAPI;
if (!isset($_SESSION)) session_start();

// Controle de Acesso
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header("Location: " . BASEURL . "paginas/login.php");
    exit;
}

$allowed_rules = ['admin', 'dono', 'funcionario'];
if (!isset($_SESSION['usuario_rule']) || !in_array($_SESSION['usuario_rule'], $allowed_rules)) {
    header("Location: " . BASEURL . "index.php?erro=acesso_negado");
    exit;
}

// Busca os usuários para listar
$pdo = new PDO(DB_DSN, DB_USER, DB_PASS, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
]);

$stmt = $pdo->query("SELECT * FROM usuarios ORDER BY id ASC");
$usuarios = $stmt->fetchAll();

include(HEADER_TEMPLATE);
?>

<!-- Estilos inline para sobrescrever cores se necessário e forçar modo escuro no container -->
<style>
    .cadastro-dark-wrapper {
        background-color: #1a1a1a !important;
        color: #e0d6c2 !important;
        min-height: 80vh;
        padding-top: 2rem;
        padding-bottom: 2rem;
    }
    .cadastro-dark-wrapper .table-dark {
        --bs-table-bg: #2a2a2a;
        --bs-table-striped-bg: #333333;
        --bs-table-hover-bg: rgba(255, 255, 255, 0.05);
    }
    .cadastro-dark-wrapper .form-control.bg-dark {
        background-color: #333 !important;
        border-color: #444 !important;
        color: #fff !important;
    }
    .cadastro-dark-wrapper .form-control.bg-dark::placeholder {
        color: #aaa;
    }
</style>

<div class="container-fluid cadastro-dark-wrapper px-4">
    <!-- Breadcrumb ou Navegação -->
    <div class="d-flex align-items-center mb-4">
        <a href="<?php echo BASEURL; ?>gestao/gestao.php" class="text-decoration-none me-3" style="color: var(--logo-claro);">
            <i class="fa-solid fa-house"></i> Gestão
        </a>
        <span class="text-muted">/</span>
        <span class="ms-3 text-white"><i class="fa-solid fa-users"></i> Usuários</span>
    </div>

    <!-- Título e Botões de Ação -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <h2 class="mb-0 text-white fw-semibold d-flex align-items-center">
            <i class="fa-solid fa-users me-2" style="color: var(--verde-claro);"></i> Usuários
        </h2>
        <div class="d-flex flex-wrap gap-2">
            <a href="#" class="btn btn-sm d-flex align-items-center" style="background-color: var(--verde-oliva); color: white;">
                <i class="fa-solid fa-plus me-2"></i> Novo Usuário
            </a>
            <a href="#" class="btn btn-sm btn-outline-light d-flex align-items-center">
                <i class="fa-solid fa-file-pdf me-2"></i> PDF Geral
            </a>
            <a href="cadastro_usuarios.php" class="btn btn-sm btn-light text-dark d-flex align-items-center">
                <i class="fa-solid fa-rotate-right me-2"></i> Atualizar
            </a>
        </div>
    </div>

    <!-- Barra de Pesquisa -->
    <div class="row mb-4">
        <div class="col-md-6 col-lg-4">
            <div class="input-group">
                <input type="text" class="form-control bg-dark border-secondary text-white" placeholder="Pesquisar por nome ou e-mail...">
                <button class="btn btn-outline-secondary" type="button" style="border-color: #444;">
                    <i class="fa-solid fa-magnifying-glass"></i> Buscar
                </button>
            </div>
        </div>
    </div>

    <!-- Tabela de Dados -->
    <div class="table-responsive rounded shadow" style="background-color: #2a2a2a;">
        <table class="table table-dark table-hover align-middle mb-0">
            <thead>
                <tr style="border-bottom: 2px solid var(--verde-oliva);">
                    <th scope="col" class="py-3 px-3">ID</th>
                    <th scope="col" class="py-3">Nome</th>
                    <th scope="col" class="py-3">E-mail</th>
                    <th scope="col" class="py-3">Nível de Acesso</th>
                    <th scope="col" class="py-3">Data Cadastro</th>
                    <th scope="col" class="py-3 text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($usuarios): ?>
                    <?php foreach ($usuarios as $user): ?>
                        <tr>
                            <td class="px-3"><?php echo $user['id']; ?></td>
                            <td class="fw-medium"><?php echo htmlspecialchars($user['nome']); ?></td>
                            <td class="text-muted"><?php echo htmlspecialchars($user['email']); ?></td>
                            <td>
                                <?php 
                                    $rule = $user['rule'];
                                    $badgeClass = 'bg-secondary';
                                    if ($rule == 'admin') $badgeClass = 'bg-danger';
                                    elseif ($rule == 'dono') $badgeClass = 'bg-warning text-dark';
                                    elseif ($rule == 'funcionario') $badgeClass = 'bg-info text-dark';
                                ?>
                                <span class="badge <?php echo $badgeClass; ?> text-uppercase" style="letter-spacing: 0.5px; font-size: 0.75rem;">
                                    <?php echo htmlspecialchars($rule); ?>
                                </span>
                            </td>
                            <td><?php echo date('d/m/Y', strtotime($user['criado_em'])); ?></td>
                            <td class="text-center">
                                <a href="#" class="btn btn-sm btn-light" title="Visualizar">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <a href="#" class="btn btn-sm btn-secondary mx-1" style="background-color: #555; border:none;" title="Editar">
                                    <i class="fa-solid fa-pen"></i>
                                </a>
                                <a href="#" class="btn btn-sm btn-danger" style="background-color: var(--botao-escuro); border:none;" title="Excluir">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">Nenhum usuário encontrado.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include(FOOTER_TEMPLATE); ?>
