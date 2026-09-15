<?php
require_once "../../config.php";
require_once DBAPI;
require_once ABSPATH . "inc/auth.php";
require_roles(['admin', 'dono']);


if (isset($_GET['id']) && (int)$_GET['id'] > 0) {
  $id = (int)$_GET['id'];
  $usuario = find('usuarios', $id);
  if (!$usuario) {
    header('Location: index.php');
    exit;
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_csrf();
    $input = is_array($_POST['usuario'] ?? null) ? $_POST['usuario'] : [];
    $data = only_allowed_fields($input, ['nome', 'email', 'senha', 'rule']);
    $data['nome'] = trim((string)($data['nome'] ?? ''));
    $data['email'] = trim((string)($data['email'] ?? ''));
    $data['rule'] = (string)($data['rule'] ?? 'cliente');
    $senha = (string)($data['senha'] ?? '');
    unset($data['senha']);
    $erro = '';

    if ($data['nome'] === '' || mb_strlen($data['nome']) > 100) {
      $erro = 'Informe um nome válido.';
    } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL) || mb_strlen($data['email']) > 100) {
      $erro = 'Informe um e-mail válido.';
    } elseif ($senha !== '' && mb_strlen($senha) < 6) {
      $erro = 'A senha deve ter no mínimo 6 caracteres.';
    } elseif (!in_array($data['rule'], ['admin', 'dono', 'funcionario', 'cliente'], true)) {
      $erro = 'Permissão inválida.';
    } else {
      $database = open_database();
      try {
        if (!$database) {
          throw new RuntimeException('Banco indisponível.');
        }
        if ($senha !== '') {
          $data['senha'] = password_hash($senha, PASSWORD_DEFAULT);
          $stmt = $database->prepare(
            'UPDATE usuarios SET nome = :nome, email = :email, senha = :senha, rule = :rule WHERE id = :id'
          );
        } else {
          $stmt = $database->prepare(
            'UPDATE usuarios SET nome = :nome, email = :email, rule = :rule WHERE id = :id'
          );
        }
        $data['id'] = $id;
        $stmt->execute($data);
        $_SESSION['message'] = 'Usuário atualizado com sucesso.';
        $_SESSION['type'] = 'success';
        close_database($database);
        header('Location: index.php');
        exit;
      } catch (Throwable $e) {
        error_log('User update error: ' . $e->getMessage());
        $erro = 'Não foi possível atualizar o usuário. Verifique se o e-mail já está em uso.';
        close_database($database);
      }
    }
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
    <?php if (!empty($erro)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($erro, ENT_QUOTES, 'UTF-8'); ?></div>
    <?php endif; ?>
    <form action="edit.php?id=<?php echo $usuario['id']; ?>" method="POST" class="shadow-sm rounded-4 bg-white p-4">
        <?php echo csrf_field(); ?>
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
