<?php
include("conexao.php");
include("header.php");
include("admin_check.php");
require_admin();

$id   = isset($_GET['id']) ? intval($_GET['id']) : null;
$data = ['item' => '', 'id_raridade' => 1, 'descricao' => ''];

$raridades = $conn->query("SELECT id, raridade FROM raridades ORDER BY id")->fetch_all(MYSQLI_ASSOC);

if ($id) {
    $s = $conn->prepare("SELECT item, id_raridade, descricao FROM itens WHERE id = ?");
    $s->bind_param("i", $id);
    $s->execute();
    $data = $s->get_result()->fetch_assoc();
    $s->close();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['item'] ?? '');
    $rar  = intval($_POST['id_raridade']);
    $desc = trim($_POST['descricao'] ?? '');

    if ($id) {
        $s = $conn->prepare("UPDATE itens SET item=?, id_raridade=?, descricao=? WHERE id=?");
        $s->bind_param("sisi", $nome, $rar, $desc, $id);
    } else {
        $s = $conn->prepare("INSERT INTO itens (item, id_raridade, descricao) VALUES (?,?,?)");
        $s->bind_param("sis", $nome, $rar, $desc);
    }
    $s->execute();
    $s->close();
    header('Location: itens.php');
    exit();
}
?>
<div class="content">
    <form class="admin-form" method="post">
        <h2><?= $id ? 'Editar Item' : 'Novo Item' ?></h2>

        <label>Nome</label>
        <input type="text" name="item" value="<?= htmlspecialchars($data['item']) ?>" required>

        <label>Raridade</label>
        <select name="id_raridade">
            <?php foreach ($raridades as $r): ?>
                <option value="<?= $r['id'] ?>" <?= $r['id'] == $data['id_raridade'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($r['raridade']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Descrição</label>
        <textarea name="descricao"><?= htmlspecialchars($data['descricao']) ?></textarea>

        <button type="submit" class="btn-admin btn-save">Salvar</button>
        <a href="itens.php" class="btn-admin btn-edit" style="text-align:center">Cancelar</a>
    </form>
</div>
</body>
</html>
