<?php
include("conexao.php"); include("header.php"); include("admin_check.php"); require_admin();
$pid = intval($_GET['id'] ?? 0);
$habs = $conn->query("SELECT habilidades_classe.id, habilidades_classe.nome, classes.classe
    FROM habilidades_classe JOIN classes ON habilidades_classe.id_classe = classes.id
    ORDER BY classes.classe, habilidades_classe.nome")->fetch_all(MYSQLI_ASSOC);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $hab_id = intval($_POST['id_habilidade']);
    $level  = intval($_POST['level']);
    $s = $conn->prepare("INSERT INTO R_player_habilidade_classe (id_player, id_habilidade_classe, level) VALUES (?,?,?)");
    $s->bind_param("iii",$pid,$hab_id,$level); $s->execute(); $s->close();
    header("Location: fichaview.php?id=$pid"); exit();
}
?>
<div class="content"><form class="admin-form" method="post">
    <h2>Adicionar Habilidade de Classe</h2>
    <label>Habilidade</label>
    <select name="id_habilidade">
        <?php foreach ($habs as $h): ?>
            <option value="<?= $h['id'] ?>">[<?= htmlspecialchars($h['classe']) ?>] <?= htmlspecialchars($h['nome']) ?></option>
        <?php endforeach; ?>
    </select>
    <label>Level</label>
    <input type="number" name="level" value="1" min="1" required>
    <button type="submit" class="btn-admin btn-save">Adicionar</button>
    <a href="fichaview.php?id=<?= $pid ?>" class="btn-admin btn-edit" style="text-align:center">Cancelar</a>
</form></div>
</body></html>
