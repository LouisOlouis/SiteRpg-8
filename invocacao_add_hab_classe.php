<?php
// invocacao_add_hab_classe.php
include("conexao.php"); include("header.php"); include("admin_check.php"); require_admin();
$inv_id = intval($_GET['id'] ?? 0);
$pid    = intval($_GET['player_id'] ?? 0);
$habs = $conn->query("
    SELECT habilidades_classe.id, habilidades_classe.nome, classes.classe
    FROM habilidades_classe
    JOIN classes ON habilidades_classe.id_classe = classes.id
    ORDER BY classes.classe, habilidades_classe.nome
")->fetch_all(MYSQLI_ASSOC);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $hab_id = intval($_POST['id_habilidade']);
    $level  = intval($_POST['level']);
    $s = $conn->prepare("INSERT INTO R_invocacao_habilidade_classe (id_invocacao, id_habilidade_classe, level) VALUES (?,?,?)");
    $s->bind_param("iii", $inv_id, $hab_id, $level); $s->execute(); $s->close();
    header("Location: invocacaoview.php?id=$inv_id&player_id=$pid"); exit();
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
    <a href="invocacaoview.php?id=<?= $inv_id ?>&player_id=<?= $pid ?>" class="btn-admin btn-edit" style="text-align:center">Cancelar</a>
</form></div>
</body></html>
