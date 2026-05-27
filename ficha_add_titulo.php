<?php
include("conexao.php"); include("header.php"); include("admin_check.php"); require_admin();
$pid = intval($_GET['id'] ?? 0);
$titulos = $conn->query("SELECT id, titulo FROM titulos ORDER BY titulo")->fetch_all(MYSQLI_ASSOC);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tit_id = intval($_POST['id_titulo']);
    $s = $conn->prepare("INSERT INTO R_player_titulo (id_player, id_titulo) VALUES (?,?)");
    $s->bind_param("ii",$pid,$tit_id); $s->execute(); $s->close();
    header("Location: fichaview.php?id=$pid"); exit();
}
?>
<div class="content"><form class="admin-form" method="post">
    <h2>Adicionar Título</h2>
    <label>Título</label>
    <select name="id_titulo">
        <?php foreach ($titulos as $t): ?>
            <option value="<?= $t['id'] ?>"><?= htmlspecialchars($t['titulo']) ?></option>
        <?php endforeach; ?>
    </select>
    <button type="submit" class="btn-admin btn-save">Adicionar</button>
    <a href="fichaview.php?id=<?= $pid ?>" class="btn-admin btn-edit" style="text-align:center">Cancelar</a>
</form></div>
</body></html>
