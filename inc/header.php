<?php
if (!isset($_SESSION)) session_start();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>  
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Marcenaria Nanias</title>
    <meta name="description" content="Sistema Marcenaria Nanias">
    <meta name="keywords" content="Marcenaria, moveis, moveis planejados">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="<?php echo BASEURL; ?>img/logo.png">

    <link rel="stylesheet" href="<?php echo BASEURL; ?>css/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo BASEURL; ?>css/awesome/all.min.css">
    <link rel="stylesheet" href="<?php echo BASEURL; ?>css/style.css?v=<?php echo time(); ?>">

</head>
<body>
    
    <nav class="navbar navbar-expand-md navbar-custom fixed-top" data-bs-theme="dark">
        <div class="container">
            <a class="navbar-brand" href="<?php echo BASEURL; ?>index.php">
                <img src="<?php echo BASEURL; ?>img/novo.png" alt="Logo Marcenaria Nanias" style="max-height: 50px; width: auto;">
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav me-auto mb-2 mb-md-0 ms-4">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASEURL; ?>index.php">Início</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Catálogo
                        </a>
                        <ul class="dropdown-menu" style="background-color: var(--header-escuro); border: none; box-shadow: 0 8px 24px rgba(0,0,0,0.2);">
                            <li>
                                <a class="dropdown-item" href="<?php echo BASEURL; ?>paginas/catalogomoveis.php" style="color: var(--fundo-creme);">
                                    <i class="fa-solid fa-couch me-2"></i>Móveis
                                </a>
                            </li>
                            <li><hr class="dropdown-divider" style="border-color: rgba(255,255,255,0.1);"></li>
                            <li>
                                <a class="dropdown-item" href="<?php echo BASEURL; ?>paginas/catalogomateriais.php" style="color: var(--fundo-creme);">
                                    <i class="fa-solid fa-tree me-2"></i>Materiais
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASEURL; ?>paginas/quem-somos.php">Quem Somos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASEURL; ?>paginas/suporte.php">Suporte</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASEURL; ?>paginas/duvidas.php">Dúvidas</a>
                    </li>
                </ul>
                
                <div class="d-flex align-items-center">
                    <button id="darkmode-toggle" class="nav-link me-3 btn btn-link p-0 border-0" title="Alternar modo escuro" aria-label="Alternar modo escuro" style="font-size: 1.2rem;">
                        <span class="theme-icon-container" style="position: relative; display: inline-flex; width: 24px; height: 24px; align-items: center; justify-content: center; overflow: visible;">
                            <i class="fa-solid fa-moon icon-moon"></i>
                            <i class="fa-solid fa-sun icon-sun" style="position: absolute;"></i>
                        </span>
                    </button>
                    <?php if (isset($_SESSION['logado']) && $_SESSION['logado'] === true): ?>
                        <?php
                            $icone = '<i class="fa-solid fa-user me-2"></i>';
                            if(isset($_SESSION['usuario_rule'])) {
                                switch($_SESSION['usuario_rule']) {
                                    case 'admin':
                                        $icone = '<i class="fa-solid fa-user-tie me-2"></i>';
                                        break;
                                    case 'dono':
                                        $icone = '<i class="fa-solid fa-crown me-2"></i>';
                                        break;
                                    case 'funcionario':
                                        $icone = '<i class="fa-solid fa-user-gear me-2"></i>';
                                        break;
                                    case 'cliente':
                                    default:
                                        $icone = '<i class="fa-solid fa-circle-user me-2"></i>';
                                        break;
                                }
                            }
                            $nome_exibicao = isset($_SESSION['usuario_nome']) ? explode(' ', trim($_SESSION['usuario_nome']))[0] : 'Usuário';
                        ?>
                        <div class="dropdown">
                            <button class="btn btn-nanias px-3 py-2 rounded-pill dropdown-toggle d-flex align-items-center" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="border:none;">
                                <?php echo $icone; ?>
                                <span class="d-none d-sm-inline fw-semibold"><?php echo htmlspecialchars($nome_exibicao); ?></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0" style="background-color: var(--header-escuro);">
                                <?php if (in_array($_SESSION['usuario_rule'] ?? '', ['admin', 'dono', 'funcionario'])): ?>
                                <li>
                                    <a class="dropdown-item" href="<?php echo BASEURL; ?>gestao/gestao.php" style="color: var(--fundo-creme);">
                                        <i class="fa-solid fa-chart-line me-2"></i>Painel Gestão
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider" style="border-color: rgba(255,255,255,0.1);"></li>
                                <?php elseif (isset($_SESSION['usuario_rule']) && $_SESSION['usuario_rule'] === 'cliente'): ?>
                                <li>
                                    <a class="dropdown-item" href="<?php echo BASEURL; ?>cliente/dashboard.php" style="color: var(--fundo-creme);">
                                        <i class="fa-solid fa-folder-open me-2"></i>Meus Projetos
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider" style="border-color: rgba(255,255,255,0.1);"></li>
                                <?php endif; ?>
                                <li>
                                    <a class="dropdown-item" href="<?php echo BASEURL; ?>paginas/logout.php" style="color: var(--fundo-creme);">
                                        <i class="fa-solid fa-sign-out-alt me-2"></i>Sair
                                    </a>
                                </li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <a href="<?php echo BASEURL; ?>paginas/login.php" class="btn btn-nanias px-4 py-2 rounded-pill d-flex align-items-center">
                            <i class="fa-solid fa-user me-2"></i><span class="d-none d-sm-inline">Entrar</span>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <main>
        <div class="container">