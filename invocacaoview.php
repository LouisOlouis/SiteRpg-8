<?php
include("conexao.php");
include("header.php");
include("admin_check.php");

$id  = isset($_GET['id'])        ? intval($_GET['id'])        : 1;
$pid = isset($_GET['player_id']) ? intval($_GET['player_id']) : 0;

// ── ACTIONS ──
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    require_admin();
    $aid = intval($_POST['rid'] ?? 0);

    switch ($_POST['action']) {
        case 'del_enc':
            $conn->query("DELETE FROM R_invocacao_encantamento WHERE id = $aid");
            break;
        case 'del_estilo':
            $conn->query("DELETE FROM R_invocacao_estiloluta WHERE id = $aid");
            break;
        case 'del_talento':
            $conn->query("DELETE FROM invocacao_talentos WHERE id = $aid AND id_invocacao = $id");
            break;
        case 'del_jutsu':
            $conn->query("DELETE FROM invocacao_jutsus WHERE id = $aid");
            break;
        case 'del_tecnica':
            $conn->query("DELETE FROM invocacao_jutsus WHERE id_tecnica = $aid");
            $conn->query("DELETE FROM invocacao_tecnicas WHERE id = $aid");
            break;
        case 'del_hab_basica':
            $conn->query("DELETE FROM R_invocacao_habilidades_basicas WHERE id = $aid");
            break;
        case 'del_hab_classe':
            $conn->query("DELETE FROM R_invocacao_habilidade_classe WHERE id = $aid");
            break;
    }

    header("Location: invocacaoview.php?id=$id&player_id=$pid");
    exit();
}

// ── QUERIES ──

$stmt = $conn->prepare("
    SELECT
        invocacao_base.nome, invocacao_base.efeitos, invocacao_base.id_player,
        classes.classe,
        invocacao_status.level, invocacao_status.hp, invocacao_status.forca,
        invocacao_status.velocidade, invocacao_status.agilidade,
        invocacao_status.durabilidade, invocacao_status.combate, invocacao_status.experiencia,
        invocacao_energias.iq, invocacao_energias.stamina,
        invocacao_energias.energia, invocacao_energias.aura,
        invocacao_mente.sanidade, invocacao_mente.sanidadeMax,
        invocacao_mente.stress, invocacao_mente.traumas, invocacao_mente.rm
    FROM invocacao_base
    LEFT JOIN classes           ON invocacao_base.id_classe = classes.id
    LEFT JOIN invocacao_status  ON invocacao_base.id = invocacao_status.id_invocacao
    LEFT JOIN invocacao_energias ON invocacao_base.id = invocacao_energias.id_invocacao
    LEFT JOIN invocacao_mente   ON invocacao_base.id = invocacao_mente.id_invocacao
    WHERE invocacao_base.id = ?
");
$stmt->bind_param("i", $id); $stmt->execute();
$inv = $stmt->get_result()->fetch_assoc(); $stmt->close();

if (!$pid && isset($inv['id_player'])) $pid = $inv['id_player'];

// estilos de luta
$stmt = $conn->prepare("
    SELECT R_invocacao_estiloluta.id as rel_id, estilos_luta.id, estilos_luta.nome
    FROM R_invocacao_estiloluta
    JOIN estilos_luta ON R_invocacao_estiloluta.id_estiloluta = estilos_luta.id
    WHERE R_invocacao_estiloluta.id_invocacao = ?
");
$stmt->bind_param("i", $id); $stmt->execute();
$estilos = $stmt->get_result()->fetch_all(MYSQLI_ASSOC); $stmt->close();

// encantamentos
$stmt = $conn->prepare("
    SELECT R_invocacao_encantamento.id as rel_id,
        encantamentos.id, encantamentos.encantamento
    FROM R_invocacao_encantamento
    JOIN encantamentos ON R_invocacao_encantamento.id_encantamentos = encantamentos.id
    WHERE R_invocacao_encantamento.id_invocacao = ?
");
$stmt->bind_param("i", $id); $stmt->execute();
$encantamentos = $stmt->get_result()->fetch_all(MYSQLI_ASSOC); $stmt->close();

// talentos
$stmt = $conn->prepare("SELECT id, nome, descricao FROM invocacao_talentos WHERE id_invocacao = ?");
$stmt->bind_param("i", $id); $stmt->execute();
$talentos = $stmt->get_result()->fetch_all(MYSQLI_ASSOC); $stmt->close();

// habilidades básicas
$stmt = $conn->prepare("
    SELECT R_invocacao_habilidades_basicas.id as rel_id,
        habilidades_basicas.id, habilidades_basicas.nome, habilidades_basicas.custo,
        energias.nome as energia_nome, R_invocacao_habilidades_basicas.level
    FROM R_invocacao_habilidades_basicas
    JOIN habilidades_basicas ON R_invocacao_habilidades_basicas.id_habilidade_basica = habilidades_basicas.id
    LEFT JOIN energias ON habilidades_basicas.id_energia_custo = energias.id
    WHERE R_invocacao_habilidades_basicas.id_invocacao = ?
");
$stmt->bind_param("i", $id); $stmt->execute();
$habs_basicas = $stmt->get_result()->fetch_all(MYSQLI_ASSOC); $stmt->close();

// habilidades de classe
$stmt = $conn->prepare("
    SELECT R_invocacao_habilidade_classe.id as rel_id,
        habilidades_classe.id, habilidades_classe.nome, habilidades_classe.custo,
        habilidades_classe.descricao, energias.nome as energia_nome,
        R_invocacao_habilidade_classe.level
    FROM R_invocacao_habilidade_classe
    JOIN habilidades_classe ON R_invocacao_habilidade_classe.id_habilidade_classe = habilidades_classe.id
    LEFT JOIN energias ON habilidades_classe.id_energia_custo = energias.id
    WHERE R_invocacao_habilidade_classe.id_invocacao = ?
");
$stmt->bind_param("i", $id); $stmt->execute();
$habs_classe = $stmt->get_result()->fetch_all(MYSQLI_ASSOC); $stmt->close();

// técnicas e jutsus
$stmt = $conn->prepare("
    SELECT
        invocacao_tecnicas.id as tec_id,
        invocacao_tecnicas.nome as nome_tecnica,
        invocacao_tecnicas.descricao as descricao_tecnica,
        invocacao_jutsus.id as jut_id,
        invocacao_jutsus.nome as nome_jutsu,
        invocacao_jutsus.custo,
        invocacao_jutsus.level,
        invocacao_jutsus.descricao as descricao_jutsu
    FROM invocacao_tecnicas
    JOIN invocacao_jutsus ON invocacao_tecnicas.id = invocacao_jutsus.id_tecnica
    WHERE invocacao_tecnicas.id_invocacao = ?
");
$stmt->bind_param("i", $id); $stmt->execute();
$result_tec = $stmt->get_result(); $stmt->close();

$tecnicas = [];
while ($row = $result_tec->fetch_assoc()) {
    $tid = $row['tec_id'];
    if (!isset($tecnicas[$tid])) {
        $tecnicas[$tid] = ['id' => $tid, 'nome' => $row['nome_tecnica'], 'descricao' => $row['descricao_tecnica'], 'jutsus' => []];
    }
    $tecnicas[$tid]['jutsus'][] = [
        'id'       => $row['jut_id'],
        'nome'     => $row['nome_jutsu'],
        'descricao'=> $row['descricao_jutsu'],
        'custo'    => $row['custo'],
        'level'    => $row['level'],
    ];
}

// ── helper ──
function del_btn($action, $rid, $inv_id, $pid, $confirm) {
    echo "<form method='post' style='display:inline' onsubmit=\"return confirm('$confirm')\">";
    echo "<input type='hidden' name='action' value='$action'>";
    echo "<input type='hidden' name='rid' value='$rid'>";
    echo "<input type='hidden' name='id' value='$inv_id'>";
    echo "<button type='submit' class='btn-admin btn-delete' style='font-size:12px;padding:4px 10px'>Remover</button>";
    echo "</form>";
}
?>

<div class="content"><h2>Invocação</h2></div>

<div class="content">
    <div class="fichas">
        <h2>Informações</h2>

        <div class="admin-bar" style="margin-bottom:12px">
            <a class="btn-admin btn-edit" href="invocacoes.php?player_id=<?= $pid ?>">← Voltar para invocações</a>
        </div>

        <?php if (is_admin()): ?>
        <div class="admin-bar" style="margin-bottom:12px">
            <a class="btn-admin btn-edit" href="invocacao_form.php?player_id=<?= $pid ?>&id=<?= $id ?>">Editar Status / Energias / Mente</a>
        </div>
        <?php endif; ?>

        <h3>Nome: <?= htmlspecialchars($inv['nome']) ?></h3>
        <h3>Classe: <?= htmlspecialchars($inv['classe'] ?? '—') ?></h3>
        <h3>Efeitos: <?= htmlspecialchars($inv['efeitos'] ?? '') ?></h3>
    </div>
</div>

<div class="content">
    <div class="fichas">
        <h2>Status</h2>
        <h3>Level: <?= htmlspecialchars($inv['level']) ?></h3>
        <h3>HP: <?= htmlspecialchars($inv['hp']) ?></h3>
        <h3>Força: <?= htmlspecialchars($inv['forca']) ?></h3>
        <h3>Velocidade: <?= htmlspecialchars($inv['velocidade']) ?></h3>
        <h3>Agilidade: <?= htmlspecialchars($inv['agilidade']) ?></h3>
        <h3>Durabilidade: <?= htmlspecialchars($inv['durabilidade']) ?></h3>
        <h3>Combate: <?= htmlspecialchars($inv['combate']) ?></h3>
        <h3>Experiência: <?= htmlspecialchars($inv['experiencia']) ?></h3>
        <br>
        <h3>IQ: <?= htmlspecialchars($inv['iq']) ?></h3>
        <h3>Stamina: <?= htmlspecialchars($inv['stamina']) ?></h3>
        <h3>Energia: <?= htmlspecialchars($inv['energia']) ?></h3>
        <h3>Aura: <?= htmlspecialchars($inv['aura']) ?></h3>
    </div>
</div>

<div class="content">
    <div class="fichas">
        <h2>Mente</h2>
        <h3>Sanidade: <?= htmlspecialchars($inv['sanidade']) ?>/<?= htmlspecialchars($inv['sanidadeMax']) ?></h3>
        <h3>Estresse: <?= htmlspecialchars($inv['stress']) ?></h3>
        <h3>Traumas: <?= htmlspecialchars($inv['traumas']) ?></h3>
        <h3>RM: <?= htmlspecialchars($inv['rm']) ?></h3>
    </div>
</div>

<div class="content">
    <div class="fichas">
        <h2>Habilidades</h2>

        <!-- Estilos de luta -->
        <h3>Estilos de Luta:</h3>
        <?php if (empty($estilos)): ?>
            <p>Sem estilo</p>
        <?php else: ?>
            <?php foreach ($estilos as $est): ?>
                <div style="display:flex;align-items:center;gap:8px;margin-bottom:4px">
                    <span><?= htmlspecialchars($est['nome']) ?></span>
                    <?php if (is_admin()) del_btn('del_estilo', $est['rel_id'], $id, $pid, 'Remover estilo de luta?') ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
        <?php if (is_admin()): ?>
        <div class="admin-bar" style="margin-top:8px">
            <a class="btn-admin btn-add" href="invocacao_add_estilo.php?id=<?= $id ?>&player_id=<?= $pid ?>">+ Estilo</a>
        </div>
        <?php endif; ?>

        <br>
        <!-- Encantamentos -->
        <h3>Encantamentos:</h3>
        <?php if (empty($encantamentos)): ?>
            <p>Sem encantamentos</p>
        <?php else: ?>
            <?php foreach ($encantamentos as $enc): ?>
                <div style="display:flex;align-items:center;gap:8px;margin-bottom:4px">
                    <a href="encantamentoview.php?id=<?= $enc['id'] ?>" class="ficha_link">
                        <p><?= htmlspecialchars($enc['encantamento']) ?></p>
                    </a>
                    <?php if (is_admin()) del_btn('del_enc', $enc['rel_id'], $id, $pid, 'Remover encantamento?') ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
        <?php if (is_admin()): ?>
        <div class="admin-bar" style="margin-top:8px">
            <a class="btn-admin btn-add" href="invocacao_add_encantamento.php?id=<?= $id ?>&player_id=<?= $pid ?>">+ Encantamento</a>
        </div>
        <?php endif; ?>

        <br>
        <!-- Talentos -->
        <h3>Talentos:</h3>
        <?php if (empty($talentos)): ?>
            <p>Sem talentos</p>
        <?php else: ?>
            <?php foreach ($talentos as $tal): ?>
                <div class="ficha" style="display:flex;justify-content:space-between;align-items:flex-start;gap:8px">
                    <div>
                        <p><strong><?= htmlspecialchars($tal['nome']) ?></strong></p>
                        <p><?= htmlspecialchars($tal['descricao']) ?></p>
                    </div>
                    <?php if (is_admin()): ?>
                    <div class="admin-bar" style="flex-shrink:0">
                        <a class="btn-admin btn-edit" href="invocacao_talento_form.php?inv_id=<?= $id ?>&player_id=<?= $pid ?>&id=<?= $tal['id'] ?>">Editar</a>
                        <?php del_btn('del_talento', $tal['id'], $id, $pid, 'Deletar talento?') ?>
                    </div>
                    <?php endif; ?>
                </div>
                <hr>
            <?php endforeach; ?>
        <?php endif; ?>
        <?php if (is_admin()): ?>
        <div class="admin-bar">
            <a class="btn-admin btn-add" href="invocacao_talento_form.php?inv_id=<?= $id ?>&player_id=<?= $pid ?>">+ Talento</a>
        </div>
        <?php endif; ?>

        <br>
        <!-- Habilidades Básicas -->
        <h3>Habilidades Básicas:</h3>
        <?php if (empty($habs_basicas)): ?>
            <p>Sem habilidades básicas</p>
        <?php else: ?>
            <?php foreach ($habs_basicas as $hab): ?>
                <div style="display:flex;align-items:center;justify-content:space-between;gap:8px">
                    <div class="subficha" style="flex:1">
                        <p><strong><?= htmlspecialchars($hab['nome']) ?></strong> (Lv <?= $hab['level'] ?>)</p>
                        <?php if ($hab['custo'] !== null): ?>
                            <p>Custo: <?= htmlspecialchars($hab['custo']) ?> <?= htmlspecialchars($hab['energia_nome'] ?? '') ?></p>
                        <?php endif; ?>
                    </div>
                    <?php if (is_admin()) del_btn('del_hab_basica', $hab['rel_id'], $id, $pid, 'Remover habilidade básica?') ?>
                </div>
                <hr>
            <?php endforeach; ?>
        <?php endif; ?>
        <?php if (is_admin()): ?>
        <div class="admin-bar">
            <a class="btn-admin btn-add" href="invocacao_add_hab_basica.php?id=<?= $id ?>&player_id=<?= $pid ?>">+ Habilidade Básica</a>
        </div>
        <?php endif; ?>

        <br>
        <!-- Habilidades de Classe -->
        <h3>Habilidades de Classe:</h3>
        <?php if (empty($habs_classe)): ?>
            <p>Sem habilidades de classe</p>
        <?php else: ?>
            <?php foreach ($habs_classe as $hab): ?>
                <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:8px">
                    <div class="subficha" style="flex:1">
                        <p><strong><?= htmlspecialchars($hab['nome']) ?></strong> (Lv <?= $hab['level'] ?>)</p>
                        <?php if ($hab['custo'] !== null): ?>
                            <p>Custo: <?= htmlspecialchars($hab['custo']) ?> <?= htmlspecialchars($hab['energia_nome'] ?? '') ?></p>
                        <?php endif; ?>
                        <?php if ($hab['descricao']): ?>
                            <p><?= htmlspecialchars($hab['descricao']) ?></p>
                        <?php endif; ?>
                    </div>
                    <?php if (is_admin()) del_btn('del_hab_classe', $hab['rel_id'], $id, $pid, 'Remover habilidade de classe?') ?>
                </div>
                <hr>
            <?php endforeach; ?>
        <?php endif; ?>
        <?php if (is_admin()): ?>
        <div class="admin-bar">
            <a class="btn-admin btn-add" href="invocacao_add_hab_classe.php?id=<?= $id ?>&player_id=<?= $pid ?>">+ Habilidade de Classe</a>
        </div>
        <?php endif; ?>

        <br>
        <!-- Técnicas e Jutsus -->
        <h3>Técnicas:</h3>
        <?php if (empty($tecnicas)): ?>
            <p>Sem técnicas</p>
        <?php else: ?>
            <?php foreach ($tecnicas as $tec): ?>
                <div class="ficha">
                    <div style="display:flex;justify-content:space-between;align-items:center;gap:8px">
                        <h3><?= htmlspecialchars($tec['nome']) ?></h3>
                        <?php if (is_admin()): ?>
                        <div class="admin-bar">
                            <a class="btn-admin btn-edit" href="invocacao_tecnica_form.php?inv_id=<?= $id ?>&player_id=<?= $pid ?>&id=<?= $tec['id'] ?>">Editar</a>
                            <?php del_btn('del_tecnica', $tec['id'], $id, $pid, 'Deletar técnica e todos os jutsus?') ?>
                        </div>
                        <?php endif; ?>
                    </div>
                    <p><?= htmlspecialchars($tec['descricao']) ?></p>

                    <h4 style="margin-top:12px">Jutsus:</h4>
                    <?php foreach ($tec['jutsus'] as $jut): ?>
                        <div class="subficha" style="display:flex;justify-content:space-between;align-items:flex-start;gap:8px">
                            <div>
                                <p><strong><?= htmlspecialchars($jut['nome']) ?></strong></p>
                                <p>Level: <?= htmlspecialchars($jut['level']) ?></p>
                                <p>Custo: <?= htmlspecialchars($jut['custo'] ?? '—') ?></p>
                                <p><?= htmlspecialchars($jut['descricao']) ?></p>
                            </div>
                            <?php if (is_admin()): ?>
                            <div class="admin-bar" style="flex-shrink:0">
                                <a class="btn-admin btn-edit" href="invocacao_jutsu_form.php?inv_id=<?= $id ?>&player_id=<?= $pid ?>&tec_id=<?= $tec['id'] ?>&id=<?= $jut['id'] ?>">Editar</a>
                                <?php del_btn('del_jutsu', $jut['id'], $id, $pid, 'Deletar jutsu?') ?>
                            </div>
                            <?php endif; ?>
                        </div>
                        <hr>
                    <?php endforeach; ?>

                    <?php if (is_admin()): ?>
                    <div class="admin-bar" style="margin-top:8px">
                        <a class="btn-admin btn-add" href="invocacao_jutsu_form.php?inv_id=<?= $id ?>&player_id=<?= $pid ?>&tec_id=<?= $tec['id'] ?>">+ Jutsu</a>
                    </div>
                    <?php endif; ?>
                </div>
                <br>
            <?php endforeach; ?>
        <?php endif; ?>
        <?php if (is_admin()): ?>
        <div class="admin-bar">
            <a class="btn-admin btn-add" href="invocacao_tecnica_form.php?inv_id=<?= $id ?>&player_id=<?= $pid ?>">+ Técnica</a>
        </div>
        <?php endif; ?>

    </div>
</div>
</body>
</html>
