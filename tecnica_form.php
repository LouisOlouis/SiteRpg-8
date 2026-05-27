<?php
include("conexao.php"); include("header.php"); include("admin_check.php"); require_admin();
$pid = intval($_GET['player_id'] ?? 0);
$id  = isset($_GET['id']) ? intval($_GET['id']) : null;
$data = ['nome'=>'','descricao'=>''];
if ($id) {
    $s = $conn->prepare("SELECT nome, descricao FROM player_tecnicas WHERE id=? AND id_player=?");
    $s->bind_param("ii",$id,$pid); $s->execute();
    $data = $s->get_result()->fetch_assoc(); $s->close();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome']);
    $desc = trim($_POST['descricao']);
    if ($id) {
        $s = $conn->prepare("UPDATE player_tecnicas SET nome=?,descricao=? WHERE id=? AND id_player=?");
        $s->bind_param("ssii",$nome,$desc,$id,$pid);
    } else {
        $s = $conn->prepare("INSERT INTO player_tecnicas (id_player,nome,descricao) VALUES (?,?,?)");
        $s->bind_param("iss",$pid,$nome,$desc);
    }
    $s->execute(); $s->close();
    header("Location: fichaview.php?id=$pid"); exit();
}
?>
<div class="content"><form class="admin-form" method="post">
    <h2><?= $id ? 'Editar Técnica' : 'Nova Técnica' ?></h2>
    <label>Nome</label>
    <input type="text" name="nome" value="<?= htmlspecialchars($data['nome']) ?>" required maxlength="15">
    <label>Descrição</label>
    <textarea name="descricao"><?= htmlspecialchars($data['descricao']) ?></textarea>
    <button type="submit" class="btn-admin btn-save">Salvar</button>
    <a href="fichaview.php?id=<?= $pid ?>" class="btn-admin btn-edit" style="text-align:center">Cancelar</a>
</form></div>
</body></html>
