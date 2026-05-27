<?php
include("conexao.php");
include("header.php");
include("admin_check.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    require_admin();
    if ($_POST['action'] === 'delete' && isset($_POST['id'])) {
        $did = intval($_POST['id']);
        // Remove todas as ligações e tabelas pessoais do player
        foreach ([
            "DELETE FROM R_item_player_encantamento WHERE id_item_player IN (SELECT id FROM R_player_item WHERE id_player = $did)",
            "DELETE FROM R_player_item WHERE id_player = $did",
            "DELETE FROM R_player_encantamento WHERE id_player = $did",
            "DELETE FROM R_player_estiloluta WHERE id_player = $did",
            "DELETE FROM R_player_titulo WHERE id_player = $did",
            "DELETE FROM R_player_habilidades_basicas WHERE id_player = $did",
            "DELETE FROM R_player_habilidade_classe WHERE id_player = $did",
            "DELETE FROM player_jutsus WHERE id_tecnica IN (SELECT id FROM player_tecnicas WHERE id_player = $did)",
            "DELETE FROM player_tecnicas WHERE id_player = $did",
            "DELETE FROM player_talentos WHERE id_player = $did",
            "DELETE FROM player_mente WHERE id_player = $did",
            "DELETE FROM player_energias WHERE id_player = $did",
            "DELETE FROM player_status WHERE id_player = $did",
            "DELETE FROM player_dinheiro WHERE id_player = $did",
            "DELETE FROM player_base WHERE id = $did",
        ] as $q) { $conn->query($q); }
    }
    header('Location: fichas.php');
    exit();
}

$stmt = $conn->prepare("SELECT id, nome FROM player_base ORDER BY nome");
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
?>

<div class="StartBlog">
    <div class="Content">
        <h1>Rpg-8</h1>
        <h3>Aqui estão as fichas dos personagens do Rpg-8</h3>
    </div>
</div>

<div class="content">
    <div class="fichas">
        <h2>Fichas</h2>

        <?php if (is_admin()): ?>
        <div class="admin-bar" style="margin-bottom:16px">
            <a class="btn-admin btn-add" href="ficha_form.php">+ Nova Ficha</a>
        </div>
        <?php endif; ?>

        <?php while ($ficha = $result->fetch_assoc()): ?>
            <div style="display:flex;align-items:center;justify-content:space-between;gap:8px">
                <a href="fichaview.php?id=<?= $ficha['id'] ?>" class="ficha_link" style="flex:1">
                    <div class="ficha">
                        <h3 class="nome_ficha"><?= htmlspecialchars($ficha['nome']) ?></h3>
                    </div>
                </a>
                <?php if (is_admin()): ?>
                <div class="admin-bar">
                    <a class="btn-admin btn-edit" href="ficha_form.php?id=<?= $ficha['id'] ?>">Editar</a>
                    <form method="post" onsubmit="return confirm('Deletar ficha completa do player? Isso remove status, técnicas, jutsus e todas as ligações.')">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id" value="<?= $ficha['id'] ?>">
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
