<?php
include("conexao.php");
include("header.php");
include("admin_check.php");
require_admin();

$id   = isset($_GET['id']) ? intval($_GET['id']) : null;
$data = ['nome' => '', 'descricao' => ''];

if ($id) {
    $s = $conn->prepare("SELECT nome, descricao FROM estilos_luta WHERE id = ?");
    $s->bind_param("i", $id);
    $s->execute();
    $data = $s->get_result()->fetch_assoc();
    $s->close();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $desc = trim($_POST['descricao'] ?? '');

    if ($id) {
        $s = $conn->prepare("UPDATE estilos_luta SET nome=?, descricao=? WHERE id=?");
        $s->bind_param("ssi", $nome, $desc, $id);
    } else {
        $s = $conn->prepare("INSERT INTO estilos_luta (nome, descricao) VALUES (?,?)");
        $s->bind_param("ss", $nome, $desc);
    }
    $s->execute();
    $s->close();
    header('Location: estilos_luta.php');
    exit();
}
?>
<div class="content">
    <form class="admin-form" method="post">
        <h2><?= $id ? 'Editar Estilo de Luta' : 'Novo Estilo de Luta' ?></h2>

        <label>Nome</label>
        <input type="text" name="nome" value="<?= htmlspecialchars($data['nome']) ?>" required>

        <label>Descrição</label>
        <textarea name="descricao"><?= htmlspecialchars($data['descricao']) ?></textarea>

        <button type="submit" class="btn-admin btn-save">Salvar</button>
        <a href="estilos_luta.php" class="btn-admin btn-edit" style="text-align:center">Cancelar</a>
    </form>
</div>
</body>
</html>
