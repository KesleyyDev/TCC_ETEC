<?php
require_once "../../config.php";
require_once DBAPI;
if (!isset($_SESSION)) session_start();
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header('Location: ' . BASEURL . 'paginas/login.php');
    exit;
}


if (isset($_GET['id'])) {
  $id = $_GET['id'];

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'];
    if (!empty($usuario['senha'])) {
        $usuario['senha'] = password_hash($usuario['senha'], PASSWORD_DEFAULT);
    } else {
        unset($usuario['senha']); // Do not update password if empty
    }
    update('usuarios', $id, $usuario);
    header('Location: index.php');
    exit;
  } else {
    $usuario = find('usuarios', $id);
  }
} else {
  header('Location: index.php');
  exit;
}

include(HEADER_TEMPLATE);
?>
<div class="container py-5 fade-in">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold" style="color: var(--logo-escuro);">Editar Usuário</h2>
        </div>
    </div>
    <form action="edit.php?id=<?php echo $usuario['id']; ?>" method="POST" class="shadow-sm rounded-4 bg-white p-4">
        <div class="row">
            <div class="form-group col-md-6 mb-3">
                <label for="name">Nome / Razão Social</label>
                <input type="text" class="form-control" name="usuario[nome]" value="<?php echo htmlspecialchars($usuario['nome']); ?>" required>
            </div>
            <div class="form-group col-md-6 mb-3">
                <label for="campo2">E-mail</label>
                <input type="email" class="form-control" name="usuario[email]" value="<?php echo htmlspecialchars($usuario['email']); ?>" required>
            </div>
            <div class="form-group col-md-6 mb-3">
                <label for="campo3">Senha (Deixe em branco para manter a atual)</label>
                <input type="password" class="form-control" name="usuario[senha]">
            </div>
            <div class="form-group col-md-6 mb-3">
                <label for="campo4">Permissão</label>
                <select class="form-control" name="usuario[rule]">
                    <option value="cliente" <?php if($usuario['rule'] == 'cliente') echo 'selected'; ?>>Cliente</option>
                    <option value="funcionario" <?php if($usuario['rule'] == 'funcionario') echo 'selected'; ?>>Funcionário</option>
                    <option value="admin" <?php if($usuario['rule'] == 'admin') echo 'selected'; ?>>Administrador</option>
                    <option value="dono" <?php if($usuario['rule'] == 'dono') echo 'selected'; ?>>Dono</option>
                </select>
            </div>
        </div>
        <div id="actions" class="row">
            <div class="col-md-12">
                <button type="submit" class="btn btn-nanias">Atualizar</button>
                <a href="index.php" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </div>
    </form>
</div>
<?php include(FOOTER_TEMPLATE); ?>
