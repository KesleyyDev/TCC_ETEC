<?php
require_once "../config.php";
require_once DBAPI;
if (!isset($_SESSION)) session_start();
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header('Location: ' . BASEURL . 'paginas/login.php');
    exit;
}

include(HEADER_TEMPLATE);
?>

<div class="container py-5 fade-in">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h2 class="fw-bold" style="color: var(--logo-escuro);">
                <i class="fa-solid fa-list me-2"></i> Lista Admin (Catálogo)
            </h2>
            <a href="gestao.php" class="btn btn-outline-nanias rounded-pill">
                <i class="fa-solid fa-arrow-left me-2"></i> Voltar
            </a>
        </div>
        <hr style="border-color: var(--verde-claro); border-width: 2px;">
    </div>

    <div class="row">
        <div class="col-12">
            <div class="table-responsive shadow-sm rounded-4 bg-white p-4">
                <table class="table table-hover align-middle">
                    <thead class="table-light text-muted">
                        <tr>
                            <th scope="col" style="width: 100px;">Imagem</th>
                            <th scope="col">ID</th>
                            <th scope="col">Título</th>
                            <th scope="col">Categoria</th>
                            <th scope="col" class="text-end">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Exemplo 1 -->
                        <tr>
                            <td>
                                <div class="rounded-3" style="width: 60px; height: 60px; background-color: var(--fundo-creme); display: flex; align-items: center; justify-content: center;">
                                    <i class="fa-solid fa-kitchen-set fa-lg" style="color: var(--logo-claro);"></i>
                                </div>
                            </td>
                            <td class="fw-bold text-muted">#001</td>
                            <td>Cozinha Planejada Premium</td>
                            <td><span class="badge" style="background-color: var(--verde-claro);">Cozinhas</span></td>
                            <td class="text-end">
                                <a href="#" class="btn btn-sm btn-outline-primary" title="Editar"><i class="fa-solid fa-pen"></i></a>
                                <a href="#" class="btn btn-sm btn-outline-danger" title="Excluir"><i class="fa-solid fa-trash"></i></a>
                            </td>
                        </tr>
                        <!-- Exemplo 2 -->
                        <tr>
                            <td>
                                <div class="rounded-3" style="width: 60px; height: 60px; background-color: #e8dbb4; display: flex; align-items: center; justify-content: center;">
                                    <i class="fa-solid fa-bed fa-lg" style="color: var(--logo-medio);"></i>
                                </div>
                            </td>
                            <td class="fw-bold text-muted">#002</td>
                            <td>Dormitório Casal Master</td>
                            <td><span class="badge" style="background-color: var(--verde-oliva);">Dormitórios</span></td>
                            <td class="text-end">
                                <a href="#" class="btn btn-sm btn-outline-primary" title="Editar"><i class="fa-solid fa-pen"></i></a>
                                <a href="#" class="btn btn-sm btn-outline-danger" title="Excluir"><i class="fa-solid fa-trash"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php 
include(FOOTER_TEMPLATE);
?>
