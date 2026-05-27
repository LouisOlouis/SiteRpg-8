<?php
include("conexao.php");
include("header.php");
include("admin_check.php");

// ── DELETE ──
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    require_admin();
    if ($_POST['action'] === 'delete' && isset($_POST['id'])) {
        $did = intval($_POST['id']);
        $conn->query("DELETE FROM R_player_encantamento WHERE id_encantamentos = $did");
        $conn->query("DELETE FROM R_item_player_encantamento WHERE id_encantamentos = $did");
        $conn->query("DELETE FROM encantamentos WHERE id = $did");
    }
    header('Location: encantamentos.php');
    exit();
}

$stmt = $conn->prepare("SELECT id, encantamento FROM encantamentos ORDER BY encantamento");
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
?>

<div class="StartBlog">
    <div class="Content">
        <h1>Rpg-8</h1>
        <h3>Aqui estão os encantamentos do Rpg-8</h3>
    </div>
</div>

<div class="content">
    <div class="fichas">
        <h2>Encantamentos</h2>

        <?php if (is_admin()): ?>
        <div class="admin-bar" style="margin-bottom:16px">
            <a class="btn-admin btn-add" href="encantamento_form.php">+ Novo Encantamento</a>
        </div>
        <?php endif; ?>

        <?php while ($enc = $result->fetch_assoc()): ?>
            <div style="display:flex;align-items:center;justify-content:space-between;gap:8px">
                <a href="encantamentoview.php?id=<?= $enc['id'] ?>" class="ficha_link" style="flex:1">
                    <div class="ficha">
                        <h3 class="nome_ficha"><?= htmlspecialchars($enc['encantamento']) ?></h3>
                    </div>
                </a>
                <?php if (is_admin()): ?>
                <div class="admin-bar">
                    <a class="btn-admin btn-edit" href="encantamento_form.php?id=<?= $enc['id'] ?>">Editar</a>
                    <form method="post" onsubmit="return confirm('Deletar encantamento e remover todas as ligações?')">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id" value="<?= $enc['id'] ?>">
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
