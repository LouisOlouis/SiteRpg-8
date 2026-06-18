<?php
// invocacao_talento_form.php
include("conexao.php"); include("header.php"); include("admin_check.php"); require_admin();
$inv_id = intval($_GET['inv_id'] ?? 0);
$pid    = intval($_GET['player_id'] ?? 0);
$id     = isset($_GET['id']) ? intval($_GET['id']) : null;
$data   = ['nome' => '', 'descricao' => ''];
if ($id) {
    $s = $conn->prepare("SELECT nome, descricao FROM invocacao_talentos WHERE id=? AND id_invocacao=?");
    $s->bind_param("ii", $id, $inv_id); $s->execute();
    $data = $s->get_result()->fetch_assoc(); $s->close();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome']);
    $desc = trim($_POST['descricao']);
    if ($id) {
        $s = $conn->prepare("UPDATE invocacao_talentos SET nome=?,descricao=? WHERE id=? AND id_invocacao=?");
        $s->bind_param("ssii", $nome, $desc, $id, $inv_id);
    } else {
        $s = $conn->prepare("INSERT INTO invocacao_talentos (id_invocacao,nome,descricao) VALUES (?,?,?)");
        $s->bind_param("iss", $inv_id, $nome, $desc);
    }
    $s->execute(); $s->close();
    header("Location: invocacaoview.php?id=$inv_id&player_id=$pid"); exit();
}
?>
<div class="content"><form class="admin-form" method="post">
    <h2><?= $id ? 'Editar Talento' : 'Novo Talento' ?></h2>
    <label>Nome</label>
    <input type="text" name="nome" value="<?= htmlspecialchars($data['nome']) ?>" required>
    <label>Descrição</label>
    <textarea name="descricao"><?= htmlspecialchars($data['descricao']) ?></textarea>
    <button type="submit" class="btn-admin btn-save">Salvar</button>
    <a href="invocacaoview.php?id=<?= $inv_id ?>&player_id=<?= $pid ?>" class="btn-admin btn-edit" style="text-align:center">Cancelar</a>
</form></div>
</body></html>
