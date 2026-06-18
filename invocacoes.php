<?php
include("conexao.php");
include("header.php");
include("admin_check.php");

$pid = intval($_GET['player_id'] ?? 0);

// ── DELETE ──
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    require_admin();
    if ($_POST['action'] === 'delete' && isset($_POST['id'])) {
        $did = intval($_POST['id']);
        $conn->query("DELETE FROM R_invocacao_estiloluta WHERE id_invocacao = $did");
        $conn->query("DELETE FROM R_invocacao_encantamento WHERE id_invocacao = $did");
        $conn->query("DELETE FROM R_invocacao_habilidades_basicas WHERE id_invocacao = $did");
        $conn->query("DELETE FROM R_invocacao_habilidade_classe WHERE id_invocacao = $did");
        $conn->query("DELETE FROM invocacao_jutsus WHERE id_tecnica IN (SELECT id FROM invocacao_tecnicas WHERE id_invocacao = $did)");
        $conn->query("DELETE FROM invocacao_tecnicas WHERE id_invocacao = $did");
        $conn->query("DELETE FROM invocacao_talentos WHERE id_invocacao = $did");
        $conn->query("DELETE FROM invocacao_mente WHERE id_invocacao = $did");
        $conn->query("DELETE FROM invocacao_energias WHERE id_invocacao = $did");
        $conn->query("DELETE FROM invocacao_status WHERE id_invocacao = $did");
        $conn->query("DELETE FROM invocacao_base WHERE id = $did");
    }
    header("Location: invocacoes.php?player_id=$pid");
    exit();
}

// Nome do player dono
$nome_player = '';
if ($pid) {
    $s = $conn->prepare("SELECT nome FROM player_base WHERE id = ?");
    $s->bind_param("i", $pid);
    $s->execute();
    $row = $s->get_result()->fetch_assoc();
    $s->close();
    $nome_player = $row['nome'] ?? '';
}

$stmt = $conn->prepare("
    SELECT invocacao_base.id, invocacao_base.nome, classes.classe
    FROM invocacao_base
    LEFT JOIN classes ON invocacao_base.id_classe = classes.id
    WHERE invocacao_base.id_player = ?
    ORDER BY invocacao_base.nome
");
$stmt->bind_param("i", $pid);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
?>

<div class="StartBlog">
    <div class="Content">
        <h1>Invocações</h1>
        <h3>Invocações de <?= htmlspecialchars($nome_player) ?></h3>
    </div>
</div>

<div class="content">
    <div class="fichas">
        <h2>Invocações</h2>

        <div class="admin-bar" style="margin-bottom:12px">
            <a class="btn-admin btn-edit" href="fichaview.php?id=<?= $pid ?>">← Voltar para a ficha</a>
        </div>

        <?php if (is_admin()): ?>
        <div class="admin-bar" style="margin-bottom:16px">
            <a class="btn-admin btn-add" href="invocacao_form.php?player_id=<?= $pid ?>">+ Nova Invocação</a>
        </div>
        <?php endif; ?>

        <?php while ($inv = $result->fetch_assoc()): ?>
            <div style="display:flex;align-items:center;justify-content:space-between;gap:8px">
                <a href="invocacaoview.php?id=<?= $inv['id'] ?>&player_id=<?= $pid ?>" class="ficha_link" style="flex:1">
                    <div class="ficha">
                        <h3 class="nome_ficha"><?= htmlspecialchars($inv['nome']) ?></h3>
                        <p style="color:#888;font-size:13px"><?= htmlspecialchars($inv['classe'] ?? '—') ?></p>
                    </div>
                </a>
                <?php if (is_admin()): ?>
                <div class="admin-bar">
                    <a class="btn-admin btn-edit" href="invocacao_form.php?player_id=<?= $pid ?>&id=<?= $inv['id'] ?>">Editar</a>
                    <form method="post" onsubmit="return confirm('Deletar invocação completa? Remove status, técnicas, jutsus e todas as ligações.')">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id" value="<?= $inv['id'] ?>">
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
