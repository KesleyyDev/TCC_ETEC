<?php
require_once "../../config.php";
require_once DBAPI;
require_once ABSPATH . "inc/auth.php";
require_roles(['admin', 'dono', 'funcionario']);

$database = open_database();
$orcamentos = [];
if ($database) {
try {
    $sql = "SELECT o.*, p.titulo as produto_titulo FROM orcamentos o LEFT JOIN produtos p ON o.produto_id = p.id ORDER BY o.data_envio DESC";
    $result = $database->query($sql);
    if ($result) {
        $orcamentos = $result->fetchAll();
    }
} catch (PDOException $e) {
    error_log('Quote list error: ' . $e->getMessage());
}
} else {
    error_log('Quote list skipped: database unavailable.');
}
close_database($database);

include(HEADER_TEMPLATE);
?>

<div class="container py-5 fade-in">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h2 class="fw-bold" style="color: var(--logo-escuro);">
                <i class="fa-solid fa-file-invoice-dollar me-2"></i> Orçamentos Recebidos
            </h2>
            <a href="../gestao.php" class="btn btn-outline-nanias rounded-pill">
                <i class="fa-solid fa-arrow-left me-1"></i> Voltar
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
                            <th>Data</th>
                            <th>Cliente</th>
                            <th>Produto de Interesse</th>
                            <th>Status</th>
                            <th class="text-end">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if ($orcamentos) : ?>
                    <?php foreach ($orcamentos as $orc) : ?>
                        <tr>
                            <td><?php echo date('d/m/Y H:i', strtotime($orc['data_envio'])); ?></td>
                            <td>
                                <strong><?php echo htmlspecialchars($orc['cliente_nome']); ?></strong><br>
                                <small class="text-muted"><?php echo htmlspecialchars($orc['cliente_email']); ?></small>
                            </td>
                            <td><?php echo $orc['produto_titulo'] ? htmlspecialchars($orc['produto_titulo']) : 'Nenhum / Geral'; ?></td>
                            <td>
                                <?php if($orc['status'] == 'novo'): ?>
                                    <span class="badge bg-primary">Novo</span>
                                <?php elseif($orc['status'] == 'em atendimento'): ?>
                                    <span class="badge bg-warning text-dark">Em Atendimento</span>
                                <?php else: ?>
                                    <span class="badge bg-success">Fechado</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end">
                                <a href="view.php?id=<?php echo $orc['id']; ?>" class="btn btn-sm btn-outline-success" title="Visualizar"><i class="fa-solid fa-eye"></i></a>
                                <?php if(in_array($_SESSION['usuario_rule'], ['admin', 'dono'], true)): ?>
                                <form action="delete.php" method="POST" class="d-inline" onsubmit="return confirm('Excluir orçamento?');">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="id" value="<?php echo (int)$orc['id']; ?>">
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Excluir"><i class="fa-solid fa-trash"></i></button>
                                </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">Nenhum orçamento recebido.</td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include(FOOTER_TEMPLATE); ?>
