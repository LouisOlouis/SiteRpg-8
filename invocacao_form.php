<?php
include("conexao.php");
include("header.php");
include("admin_check.php");
require_admin();

$pid = intval($_GET['player_id'] ?? 0);
$id  = isset($_GET['id']) ? intval($_GET['id']) : null;

$classes = $conn->query("SELECT id, classe FROM classes ORDER BY classe")->fetch_all(MYSQLI_ASSOC);

$base    = ['nome' => '', 'id_classe' => 1, 'efeitos' => ''];
$status  = ['level' => 1, 'hp' => 100, 'forca' => 1, 'velocidade' => 1, 'agilidade' => 1, 'durabilidade' => 1, 'combate' => 1, 'experiencia' => 0];
$energias = ['iq' => 100, 'stamina' => 100, 'energia' => 100, 'aura' => 10];
$mente   = ['sanidade' => 100, 'sanidadeMax' => 100, 'stress' => 0, 'traumas' => 0, 'rm' => 10];

if ($id) {
    $s = $conn->prepare("SELECT nome, id_classe, efeitos, id_player FROM invocacao_base WHERE id = ?");
    $s->bind_param("i", $id); $s->execute();
    $base = $s->get_result()->fetch_assoc(); $s->close();
    // garante que player_id bate
    if (!$pid) $pid = $base['id_player'];

    $s = $conn->prepare("SELECT level, hp, forca, velocidade, agilidade, durabilidade, combate, experiencia FROM invocacao_status WHERE id_invocacao = ?");
    $s->bind_param("i", $id); $s->execute();
    $status = $s->get_result()->fetch_assoc() ?? $status; $s->close();

    $s = $conn->prepare("SELECT iq, stamina, energia, aura FROM invocacao_energias WHERE id_invocacao = ?");
    $s->bind_param("i", $id); $s->execute();
    $energias = $s->get_result()->fetch_assoc() ?? $energias; $s->close();

    $s = $conn->prepare("SELECT sanidade, sanidadeMax, stress, traumas, rm FROM invocacao_mente WHERE id_invocacao = ?");
    $s->bind_param("i", $id); $s->execute();
    $mente = $s->get_result()->fetch_assoc() ?? $mente; $s->close();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome      = trim($_POST['nome']);
    $id_classe = intval($_POST['id_classe']);
    $efeitos   = trim($_POST['efeitos']);

    if ($id) {
        $s = $conn->prepare("UPDATE invocacao_base SET nome=?, id_classe=?, efeitos=? WHERE id=?");
        $s->bind_param("sisi", $nome, $id_classe, $efeitos, $id);
        $s->execute(); $s->close();

        $s = $conn->prepare("UPDATE invocacao_status SET level=?,hp=?,forca=?,velocidade=?,agilidade=?,durabilidade=?,combate=?,experiencia=? WHERE id_invocacao=?");
        $s->bind_param("iiiiiiiii", $_POST['level'],$_POST['hp'],$_POST['forca'],$_POST['velocidade'],$_POST['agilidade'],$_POST['durabilidade'],$_POST['combate'],$_POST['experiencia'],$id);
        $s->execute(); $s->close();

        $s = $conn->prepare("UPDATE invocacao_energias SET iq=?,stamina=?,energia=?,aura=? WHERE id_invocacao=?");
        $s->bind_param("iiiii", $_POST['iq'],$_POST['stamina'],$_POST['energia'],$_POST['aura'],$id);
        $s->execute(); $s->close();

        $s = $conn->prepare("UPDATE invocacao_mente SET sanidade=?,sanidadeMax=?,stress=?,traumas=?,rm=? WHERE id_invocacao=?");
        $s->bind_param("iiiiii", $_POST['sanidade'],$_POST['sanidadeMax'],$_POST['stress'],$_POST['traumas'],$_POST['rm'],$id);
        $s->execute(); $s->close();

    } else {
        $s = $conn->prepare("INSERT INTO invocacao_base (nome, id_classe, efeitos, id_player) VALUES (?,?,?,?)");
        $s->bind_param("sisi", $nome, $id_classe, $efeitos, $pid);
        $s->execute();
        $id = $conn->insert_id;
        $s->close();

        $s = $conn->prepare("INSERT INTO invocacao_status (id_invocacao,level,hp,forca,velocidade,agilidade,durabilidade,combate,experiencia) VALUES (?,?,?,?,?,?,?,?,?)");
        $s->bind_param("iiiiiiiii",$id,$_POST['level'],$_POST['hp'],$_POST['forca'],$_POST['velocidade'],$_POST['agilidade'],$_POST['durabilidade'],$_POST['combate'],$_POST['experiencia']);
        $s->execute(); $s->close();

        $s = $conn->prepare("INSERT INTO invocacao_energias (id_invocacao,iq,stamina,energia,aura) VALUES (?,?,?,?,?)");
        $s->bind_param("iiiii",$id,$_POST['iq'],$_POST['stamina'],$_POST['energia'],$_POST['aura']);
        $s->execute(); $s->close();

        $s = $conn->prepare("INSERT INTO invocacao_mente (id_invocacao,sanidade,sanidadeMax,stress,traumas,rm) VALUES (?,?,?,?,?,?)");
        $s->bind_param("iiiiii",$id,$_POST['sanidade'],$_POST['sanidadeMax'],$_POST['stress'],$_POST['traumas'],$_POST['rm']);
        $s->execute(); $s->close();
    }

    header("Location: invocacaoview.php?id=$id&player_id=$pid");
    exit();
}

function field($label, $name, $value) {
    echo "<label>$label</label>";
    echo "<input type='number' name='$name' value='" . htmlspecialchars($value) . "' required>";
}
?>

<div class="content">
    <form class="admin-form" method="post">
        <h2><?= $id ? 'Editar Invocação' : 'Nova Invocação' ?></h2>

        <div class="admin-section">
            <h3 style="margin-bottom:10px">Informações</h3>
            <label>Nome</label>
            <input type="text" name="nome" value="<?= htmlspecialchars($base['nome']) ?>" required>

            <label>Classe</label>
            <select name="id_classe">
                <?php foreach ($classes as $c): ?>
                    <option value="<?= $c['id'] ?>" <?= $c['id'] == $base['id_classe'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($c['classe']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label>Efeitos / Observações</label>
            <input type="text" name="efeitos" value="<?= htmlspecialchars($base['efeitos'] ?? '') ?>">
        </div>

        <div class="admin-section">
            <h3 style="margin-bottom:10px">Status</h3>
            <?php
            field('Level',       'level',       $status['level']);
            field('HP',          'hp',          $status['hp']);
            field('Força',       'forca',       $status['forca']);
            field('Velocidade',  'velocidade',  $status['velocidade']);
            field('Agilidade',   'agilidade',   $status['agilidade']);
            field('Durabilidade','durabilidade',$status['durabilidade']);
            field('Combate',     'combate',     $status['combate']);
            field('Experiência', 'experiencia', $status['experiencia']);
            ?>
        </div>

        <div class="admin-section">
            <h3 style="margin-bottom:10px">Energias</h3>
            <?php
            field('IQ',      'iq',      $energias['iq']);
            field('Stamina', 'stamina', $energias['stamina']);
            field('Energia', 'energia', $energias['energia']);
            field('Aura',    'aura',    $energias['aura']);
            ?>
        </div>

        <div class="admin-section">
            <h3 style="margin-bottom:10px">Mente</h3>
            <?php
            field('Sanidade',     'sanidade',    $mente['sanidade']);
            field('Sanidade Máx', 'sanidadeMax', $mente['sanidadeMax']);
            field('Stress',       'stress',      $mente['stress']);
            field('Traumas',      'traumas',     $mente['traumas']);
            field('RM',           'rm',          $mente['rm']);
            ?>
        </div>

        <button type="submit" class="btn-admin btn-save">Salvar</button>
        <a href="invocacoes.php?player_id=<?= $pid ?>" class="btn-admin btn-edit" style="text-align:center">Cancelar</a>
    </form>
</div>
</body>
</html>
