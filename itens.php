<?php
include("conexao.php");
include("header.php");
include("admin_check.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    require_admin();
    if ($_POST['action'] === 'delete' && isset($_POST['id'])) {
        $did = intval($_POST['id']);
        // Remove ligações; o item em si permanece no catálogo
        $conn->query("DELETE FROM R_item_player_encantamento WHERE id_item_player IN (SELECT id FROM R_player_item WHERE id_item = $did)");
        $conn->query("DELETE FROM R_player_item WHERE id_item = $did");
        $conn->query("DELETE FROM itens WHERE id = $did");
    }
    header('Location: itens.php');
    exit();
}

$stmt = $conn->prepare("SELECT itens.id, itens.item, raridades.raridade FROM itens JOIN raridades ON itens.id_raridade = raridades.id ORDER BY itens.item");
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
?>

<div class="StartBlog">
    <div class="Content">
        <h1>Rpg-8</h1>
        <h3>Aqui estão os itens do Rpg-8</h3>
    </div>
</div>

<div class="content">
    <div class="fichas">
        <h2>Itens</h2>

        <?php if (is_admin()): ?>
        <div class="admin-bar" style="margin-bottom:16px">
            <a class="btn-admin btn-add" href="item_form.php">+ Novo Item</a>
        </div>
        <?php endif; ?>

        <?php while ($item = $result->fetch_assoc()): ?>
            <div style="display:flex;align-items:center;justify-content:space-between;gap:8px">
                <a href="itemview.php?id=<?= $item['id'] ?>" class="ficha_link" style="flex:1">
                    <div class="ficha">
                        <h3 class="nome_ficha"><?= htmlspecialchars($item['item']) ?></h3>
                        <p style="color:#888;font-size:13px"><?= htmlspecialchars($item['raridade']) ?></p>
                    </div>
                </a>
                <?php if (is_admin()): ?>
                <div class="admin-bar">
                    <a class="btn-admin btn-edit" href="item_form.php?id=<?= $item['id'] ?>">Editar</a>
                    <form method="post" onsubmit="return confirm('Deletar item e remover todas as ligações com players?')">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id" value="<?= $item['id'] ?>">
                        <button type="submit" class="btn-admin btn-delete">Deletar</button>
                    </form>
                </div>
                <?php endif; ?>
            </div>
            <hr>
        <?php endwhile; ?>
    </div>
</div>
</body>
</html>
