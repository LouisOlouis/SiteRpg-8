<?php
include("conexao.php"); include("header.php"); include("admin_check.php"); require_admin();
$pid = intval($_GET['id'] ?? 0);
$encs = $conn->query("SELECT id, encantamento FROM encantamentos ORDER BY encantamento")->fetch_all(MYSQLI_ASSOC);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $enc_id = intval($_POST['id_encantamento']);
    $level  = intval($_POST['level']);
    $s = $conn->prepare("INSERT INTO R_player_encantamento (id_player, id_encantamentos, level) VALUES (?,?,?)");
    $s->bind_param("iii",$pid,$enc_id,$level); $s->execute(); $s->close();
    header("Location: fichaview.php?id=$pid"); exit();
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
    <label>Level</label>
    <input type="number" name="level" value="1" min="1" required>
    <button type="submit" class="btn-admin btn-save">Adicionar</button>
    <a href="fichaview.php?id=<?= $pid ?>" class="btn-admin btn-edit" style="text-align:center">Cancelar</a>
</form></div>
</body></html>
