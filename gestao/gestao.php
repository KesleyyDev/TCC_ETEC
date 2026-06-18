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

include(HEADER_TEMPLATE);
?>

    <div class="row mt-5 fade-in">
        <div class="col-md-12">
            <h2 style="color: var(--logo-escuro); font-weight: 600;">
                <i class="fa-solid fa-boxes-stacked me-2"></i> Gestão do Sistema
            </h2>
            <hr style="border-color: var(--verde-claro); border-width: 2px;">
        </div>
    </div>

    <div class="row mt-4 mb-5 slide-up delay-1">
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100 border-0" style="background-color: #ffffff; border-radius: 10px;">
                <div class="card-body text-center py-5">
                    <i class="fa-solid fa-folder-plus fa-3x mb-3" style="color: var(--logo-medio);"></i>
                    <h5 class="card-title" style="color: var(--header-escuro);">Cadastro do Catálogo</h5>
                    <p class="card-text text-muted mb-4">Adicione novos projetos e móveis ao catálogo do site.</p>
                    <a href="add.php" class="btn px-4" style="background-color: var(--logo-escuro); color: #ffffff; font-weight: 500;">
                        <i class="fa-solid fa-plus me-1"></i> Cadastrar
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100 border-0" style="background-color: #ffffff; border-radius: 10px;">
                <div class="card-body text-center py-5">
                    <i class="fa-solid fa-address-book fa-3x mb-3" style="color: var(--logo-claro);"></i>
                    <h5 class="card-title" style="color: var(--header-escuro);">Lista Admin</h5>
                    <p class="card-text text-muted mb-4">Visualize a lista de registros com imagens (apenas para administrador).</p>
                    <a href="lista_admin.php" class="btn px-4" style="background-color: var(--verde-oliva); color: #ffffff; font-weight: 500;">
                        <i class="fa-solid fa-list me-1"></i> Ver Lista
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100 border-0" style="background-color: #ffffff; border-radius: 10px;">
                <div class="card-body text-center py-5">
                    <i class="fa-solid fa-file-csv fa-3x mb-3" style="color: var(--verde-claro);"></i>
                    <h5 class="card-title" style="color: var(--header-escuro);">Gerar Arquivo CSV</h5>
                    <p class="card-text text-muted mb-4">Exporte os dados do sistema em uma planilha CSV.</p>
                    <a href="csv.php" class="btn px-4" style="background-color: var(--header-escuro); color: #FFFFFF; font-weight: 500;">
                        <i class="fa-solid fa-download me-1"></i> Exportar
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100 border-0" style="background-color: #ffffff; border-radius: 10px;">
                <div class="card-body text-center py-5">
                    <i class="fa-solid fa-users fa-3x mb-3" style="color: var(--botao-escuro);"></i>
                    <h5 class="card-title" style="color: var(--header-escuro);">Cadastro de Usuários</h5>
                    <p class="card-text text-muted mb-4">Gerencie os usuários do sistema em formato tabular.</p>
                    <a href="../cadastro/cadastro_usuarios.php" class="btn px-4" style="background-color: var(--botao-escuro); color: #ffffff; font-weight: 500;">
                        <i class="fa-solid fa-user-plus me-1"></i> Usuários
                    </a>
                </div>
            </div>
        </div>
    </div>

<?php 
include(FOOTER_TEMPLATE);
?>