<?php
include("conexao.php");
include("header.php");
include("admin_check.php");
require_admin();

$id   = isset($_GET['id']) ? intval($_GET['id']) : null;
$data = ['encantamento' => '', 'descricao' => ''];

if ($id) {
    $s = $conn->prepare("SELECT encantamento, descricao FROM encantamentos WHERE id = ?");
    $s->bind_param("i", $id);
    $s->execute();
    $data = $s->get_result()->fetch_assoc();
    $s->close();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['encantamento'] ?? '');
    $desc = trim($_POST['descricao'] ?? '');

    if ($id) {
        $s = $conn->prepare("UPDATE encantamentos SET encantamento=?, descricao=? WHERE id=?");
        $s->bind_param("ssi", $nome, $desc, $id);
    } else {
        $s = $conn->prepare("INSERT INTO encantamentos (encantamento, descricao) VALUES (?,?)");
        $s->bind_param("ss", $nome, $desc);
    }
    $s->execute();
    $s->close();
    header('Location: encantamentos.php');
    exit();
}
?>
<div class="content">
    <form class="admin-form" method="post">
        <h2><?= $id ? 'Editar Encantamento' : 'Novo Encantamento' ?></h2>

        <label>Nome</label>
        <input type="text" name="encantamento" value="<?= htmlspecialchars($data['encantamento']) ?>" required>

        <label>Descrição</label>
        <textarea name="descricao"><?= htmlspecialchars($data['descricao']) ?></textarea>

        <button type="submit" class="btn-admin btn-save">Salvar</button>
        <a href="encantamentos.php" class="btn-admin btn-edit" style="text-align:center">Cancelar</a>
    </form>
</div>
</body>
</html>
