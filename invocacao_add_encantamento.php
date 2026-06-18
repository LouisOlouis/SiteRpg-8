<?php
// invocacao_add_encantamento.php
include("conexao.php"); include("header.php"); include("admin_check.php"); require_admin();
$inv_id = intval($_GET['id'] ?? 0);
$pid    = intval($_GET['player_id'] ?? 0);
$encs = $conn->query("SELECT id, encantamento FROM encantamentos ORDER BY encantamento")->fetch_all(MYSQLI_ASSOC);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $enc_id = intval($_POST['id_encantamento']);
    $s = $conn->prepare("INSERT INTO R_invocacao_encantamento (id_invocacao, id_encantamentos) VALUES (?,?)");
    $s->bind_param("ii", $inv_id, $enc_id); $s->execute(); $s->close();
    header("Location: invocacaoview.php?id=$inv_id&player_id=$pid"); exit();
}
?>
<div class="content"><form class="admin-form" method="post">
    <h2>Adicionar Encantamento</h2>
    <label>Encantamento</label>
    <select name="id_encantamento">
        <?php foreach ($encs as $e): ?>
            <option value="<?= $e['id'] ?>"><?= htmlspecialchars($e['encantamento']) ?></option>
        <?php endforeach; ?>
    </select>
    <button type="submit" class="btn-admin btn-save">Adicionar</button>
    <a href="invocacaoview.php?id=<?= $inv_id ?>&player_id=<?= $pid ?>" class="btn-admin btn-edit" style="text-align:center">Cancelar</a>
</form></div>
</body></html>
