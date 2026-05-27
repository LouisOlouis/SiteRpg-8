<?php
include("conexao.php");
include("header.php");
include("admin_check.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    require_admin();
    if ($_POST['action'] === 'delete' && isset($_POST['id'])) {
        $did = intval($_POST['id']);
        $conn->query("DELETE FROM R_player_estiloluta WHERE id_estiloluta = $did");
        $conn->query("DELETE FROM R_invocacao_estiloluta WHERE id_estiloluta = $did");
        $conn->query("DELETE FROM estilos_luta WHERE id = $did");
    }
    header('Location: estilos_luta.php');
    exit();
}

$stmt = $conn->prepare("SELECT id, nome FROM estilos_luta ORDER BY nome");
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
?>

<div class="StartBlog">
    <div class="Content">
        <h1>Rpg-8</h1>
        <h3>Aqui estão os estilos de luta do Rpg-8</h3>
    </div>
</div>

<div class="content">
    <div class="fichas">
        <h2>Estilos de Luta</h2>

        <?php if (is_admin()): ?>
        <div class="admin-bar" style="margin-bottom:16px">
            <a class="btn-admin btn-add" href="estilo_form.php">+ Novo Estilo</a>
        </div>
        <?php endif; ?>

        <?php while ($estilo = $result->fetch_assoc()): ?>
            <div style="display:flex;align-items:center;justify-content:space-between;gap:8px">
                <div class="ficha" style="flex:1">
                    <h3 class="nome_ficha"><?= htmlspecialchars($estilo['nome']) ?></h3>
                </div>
                <?php if (is_admin()): ?>
                <div class="admin-bar">
                    <a class="btn-admin btn-edit" href="estilo_form.php?id=<?= $estilo['id'] ?>">Editar</a>
                    <form method="post" onsubmit="return confirm('Deletar estilo e remover ligações com players?')">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id" value="<?= $estilo['id'] ?>">
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
