<?php
// ════════════════════════════════════════════════════════════
// ficha_add_item.php — vincula um item existente ao player
// ════════════════════════════════════════════════════════════
// Para separar em arquivos individuais, cada bloco abaixo
// é um arquivo próprio. Aqui estão todos juntos para entrega.
// Basta copiar cada bloco para seu respectivo arquivo.
?>
<?php /* ── ARQUIVO: ficha_add_item.php ── */ ?>
<?php
include("conexao.php"); include("header.php"); include("admin_check.php"); require_admin();
$pid = intval($_GET['id'] ?? 0);
$itens = $conn->query("SELECT id, item FROM itens ORDER BY item")->fetch_all(MYSQLI_ASSOC);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $item_id = intval($_POST['id_item']);
    $s = $conn->prepare("INSERT INTO R_player_item (id_player, id_item) VALUES (?,?)");
    $s->bind_param("ii",$pid,$item_id); $s->execute(); $s->close();
    header("Location: fichaview.php?id=$pid"); exit();
}
?>
<div class="content"><form class="admin-form" method="post">
    <h2>Adicionar Item</h2>
    <label>Item</label>
    <select name="id_item">
        <?php foreach ($itens as $i): ?>
            <option value="<?= $i['id'] ?>"><?= htmlspecialchars($i['item']) ?></option>
        <?php endforeach; ?>
    </select>
    <button type="submit" class="btn-admin btn-save">Adicionar</button>
    <a href="fichaview.php?id=<?= $pid ?>" class="btn-admin btn-edit" style="text-align:center">Cancelar</a>
</form></div>
</body></html>
