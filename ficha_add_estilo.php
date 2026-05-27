<?php
include("conexao.php"); include("header.php"); include("admin_check.php"); require_admin();
$pid = intval($_GET['id'] ?? 0);
$estilos = $conn->query("SELECT id, nome FROM estilos_luta ORDER BY nome")->fetch_all(MYSQLI_ASSOC);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $est_id = intval($_POST['id_estiloluta']);
    $s = $conn->prepare("INSERT INTO R_player_estiloluta (id_player, id_estiloluta) VALUES (?,?)");
    $s->bind_param("ii",$pid,$est_id); $s->execute(); $s->close();
    header("Location: fichaview.php?id=$pid"); exit();
}
?>
<div class="content"><form class="admin-form" method="post">
    <h2>Adicionar Estilo de Luta</h2>
    <label>Estilo</label>
    <select name="id_estiloluta">
        <?php foreach ($estilos as $e): ?>
            <option value="<?= $e['id'] ?>"><?= htmlspecialchars($e['nome']) ?></option>
        <?php endforeach; ?>
    </select>
    <button type="submit" class="btn-admin btn-save">Adicionar</button>
    <a href="fichaview.php?id=<?= $pid ?>" class="btn-admin btn-edit" style="text-align:center">Cancelar</a>
</form></div>
</body></html>
