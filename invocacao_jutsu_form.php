<?php
// invocacao_jutsu_form.php
include("conexao.php"); include("header.php"); include("admin_check.php"); require_admin();
$inv_id = intval($_GET['inv_id']    ?? 0);
$pid    = intval($_GET['player_id'] ?? 0);
$tec_id = intval($_GET['tec_id']    ?? 0);
$id     = isset($_GET['id']) ? intval($_GET['id']) : null;
$energias = $conn->query("SELECT id, nome FROM energias ORDER BY id")->fetch_all(MYSQLI_ASSOC);
$data = ['nome' => '', 'custo' => '', 'id_energia_custo' => 2, 'level' => 1, 'descricao' => ''];
if ($id) {
    $s = $conn->prepare("SELECT nome,custo,id_energia_custo,level,descricao FROM invocacao_jutsus WHERE id=? AND id_tecnica=?");
    $s->bind_param("ii", $id, $tec_id); $s->execute();
    $data = $s->get_result()->fetch_assoc(); $s->close();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome  = trim($_POST['nome']);
    $custo = $_POST['custo'] !== '' ? intval($_POST['custo']) : null;
    $eng   = intval($_POST['id_energia_custo']);
    $level = intval($_POST['level']);
    $desc  = trim($_POST['descricao']);
    if ($id) {
        $s = $conn->prepare("UPDATE invocacao_jutsus SET nome=?,custo=?,id_energia_custo=?,level=?,descricao=? WHERE id=? AND id_tecnica=?");
        $s->bind_param("siisiis", $nome, $custo, $eng, $level, $desc, $id, $tec_id);
    } else {
        $s = $conn->prepare("INSERT INTO invocacao_jutsus (id_tecnica,nome,custo,id_energia_custo,level,descricao) VALUES (?,?,?,?,?,?)");
        $s->bind_param("isiiss", $tec_id, $nome, $custo, $eng, $level, $desc);
    }
    $s->execute(); $s->close();
    header("Location: invocacaoview.php?id=$inv_id&player_id=$pid"); exit();
}
?>
<div class="content"><form class="admin-form" method="post">
    <h2><?= $id ? 'Editar Jutsu' : 'Novo Jutsu' ?></h2>
    <label>Nome</label>
    <input type="text" name="nome" value="<?= htmlspecialchars($data['nome']) ?>" required maxlength="25">
    <label>Custo (deixe vazio se bloqueado)</label>
    <input type="number" name="custo" value="<?= htmlspecialchars($data['custo'] ?? '') ?>">
    <label>Energia</label>
    <select name="id_energia_custo">
        <?php foreach ($energias as $e): ?>
            <option value="<?= $e['id'] ?>" <?= $e['id'] == $data['id_energia_custo'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($e['nome']) ?>
            </option>
        <?php endforeach; ?>
    </select>
    <label>Level</label>
    <input type="number" name="level" value="<?= htmlspecialchars($data['level']) ?>" min="1" required>
    <label>Descrição</label>
    <textarea name="descricao"><?= htmlspecialchars($data['descricao']) ?></textarea>
    <button type="submit" class="btn-admin btn-save">Salvar</button>
    <a href="invocacaoview.php?id=<?= $inv_id ?>&player_id=<?= $pid ?>" class="btn-admin btn-edit" style="text-align:center">Cancelar</a>
</form></div>
</body></html>
