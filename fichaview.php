<?php
//fichaview.php
include("conexao.php");
include("header.php");
include("admin_check.php");

$id = isset($_GET['id']) ? intval($_GET['id']) : 1;

// ── ACTIONS (delete de ligações) ──────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    require_admin();
    $aid = intval($_POST['rid'] ?? 0);

    switch ($_POST['action']) {

        case 'del_item':
            $conn->query("DELETE FROM R_item_player_encantamento WHERE id_item_player = $aid");
            $conn->query("DELETE FROM R_player_item WHERE id = $aid");
            break;

        case 'del_enc_player':
            $conn->query("DELETE FROM R_player_encantamento WHERE id = $aid");
            break;

        case 'del_estilo':
            $conn->query("DELETE FROM R_player_estiloluta WHERE id = $aid");
            break;

        case 'del_titulo':
            $conn->query("DELETE FROM R_player_titulo WHERE id = $aid");
            break;

        case 'del_talento':
            $conn->query("DELETE FROM player_talentos WHERE id = $aid AND id_player = $id");
            break;

        case 'del_jutsu':
            $conn->query("DELETE FROM player_jutsus WHERE id = $aid");
            break;

        case 'del_tecnica':
            $conn->query("DELETE FROM player_jutsus WHERE id_tecnica = $aid");
            $conn->query("DELETE FROM player_tecnicas WHERE id = $aid");
            break;

        case 'del_hab_basica':
            $conn->query("DELETE FROM R_player_habilidades_basicas WHERE id = $aid");
            break;

        case 'del_hab_classe':
            $conn->query("DELETE FROM R_player_habilidade_classe WHERE id = $aid");
            break;
    }

    header("Location: fichaview.php?id=$id");
    exit();
}

// ── QUERIES ───────────────────────────────────────────────────

$stmt = $conn->prepare("SELECT
    player_base.nome, player_base.efeitos,
    classes.classe,
    player_dinheiro.dinheiro, player_dinheiro.fragmento,
    player_status.level, player_status.hp, player_status.forca,
    player_status.velocidade, player_status.agilidade,
    player_status.durabilidade, player_status.combate, player_status.experiencia,
    player_energias.iq, player_energias.stamina, player_energias.energia, player_energias.aura,
    player_mente.sanidade, player_mente.sanidadeMax, player_mente.stress,
    player_mente.traumas, player_mente.rm,
    (SELECT GROUP_CONCAT(t.titulo SEPARATOR '| ')
     FROM R_player_titulo rpt JOIN titulos t ON rpt.id_titulo = t.id
     WHERE rpt.id_player = player_base.id) AS titulos
FROM player_base
JOIN classes ON player_base.id_classe = classes.id
LEFT JOIN player_dinheiro  ON player_base.id = player_dinheiro.id_player
LEFT JOIN player_status    ON player_base.id = player_status.id_player
LEFT JOIN player_energias  ON player_base.id = player_energias.id_player
LEFT JOIN player_mente     ON player_base.id = player_mente.id_player
WHERE player_base.id = ?");
$stmt->bind_param("i",$id); $stmt->execute();
$ficha = $stmt->get_result()->fetch_assoc(); $stmt->close();

// itens
$stmt = $conn->prepare("SELECT
    R_player_item.id as rel_id,
    itens.id as id_itens, itens.item,
    R_item_player_encantamento.level as enc_level,
    encantamentos.id as id_encantamentos, encantamentos.encantamento
FROM R_player_item
JOIN itens ON R_player_item.id_item = itens.id
LEFT JOIN R_item_player_encantamento ON R_player_item.id = R_item_player_encantamento.id_item_player
LEFT JOIN encantamentos ON R_item_player_encantamento.id_encantamentos = encantamentos.id
WHERE R_player_item.id_player = ?");
$stmt->bind_param("i",$id); $stmt->execute();
$result_itens = $stmt->get_result(); $stmt->close();

$itensAgrupados = [];
while ($row = $result_itens->fetch_assoc()) {
    $rid = $row['rel_id'];
    if (!isset($itensAgrupados[$rid])) {
        $itensAgrupados[$rid] = ['rel_id'=>$rid,'id'=>$row['id_itens'],'item'=>$row['item'],'encantamentos'=>[]];
    }
    if ($row['encantamento']) {
        $itensAgrupados[$rid]['encantamentos'][] = [
            'id'=>$row['id_encantamentos'],'nome'=>$row['encantamento'],'level'=>$row['enc_level']
        ];
    }
}

// estilos de luta (com rel id)
$stmt = $conn->prepare("SELECT R_player_estiloluta.id as rel_id, estilos_luta.id, estilos_luta.nome
    FROM R_player_estiloluta
    JOIN estilos_luta ON R_player_estiloluta.id_estiloluta = estilos_luta.id
    WHERE R_player_estiloluta.id_player = ?");
$stmt->bind_param("i",$id); $stmt->execute();
$estilos = $stmt->get_result()->fetch_all(MYSQLI_ASSOC); $stmt->close();

// encantamentos do player (com rel id)
$stmt = $conn->prepare("SELECT R_player_encantamento.id as rel_id,
    encantamentos.id, encantamentos.encantamento, R_player_encantamento.level
    FROM R_player_encantamento
    JOIN encantamentos ON R_player_encantamento.id_encantamentos = encantamentos.id
    WHERE R_player_encantamento.id_player = ?");
$stmt->bind_param("i",$id); $stmt->execute();
$encantamentos = $stmt->get_result()->fetch_all(MYSQLI_ASSOC); $stmt->close();

// títulos (com rel id)
$stmt = $conn->prepare("SELECT R_player_titulo.id as rel_id, titulos.id, titulos.titulo
    FROM R_player_titulo JOIN titulos ON R_player_titulo.id_titulo = titulos.id
    WHERE R_player_titulo.id_player = ?");
$stmt->bind_param("i",$id); $stmt->execute();
$titulos = $stmt->get_result()->fetch_all(MYSQLI_ASSOC); $stmt->close();

// talentos (com id)
$stmt = $conn->prepare("SELECT id, nome, descricao FROM player_talentos WHERE id_player = ?");
$stmt->bind_param("i",$id); $stmt->execute();
$talentos = $stmt->get_result()->fetch_all(MYSQLI_ASSOC); $stmt->close();

// técnicas e jutsus
$stmt = $conn->prepare("SELECT
    player_tecnicas.id as tec_id, player_tecnicas.nome as nome_tecnica, player_tecnicas.descricao as descricao_tecnica,
    player_jutsus.id as jut_id, player_jutsus.nome as nome_jutsu,
    player_jutsus.custo, player_jutsus.level, player_jutsus.descricao as descricao_jutsu
FROM player_tecnicas
JOIN player_jutsus ON player_tecnicas.id = player_jutsus.id_tecnica
WHERE player_tecnicas.id_player = ?");
$stmt->bind_param("i",$id); $stmt->execute();
$result_tec = $stmt->get_result(); $stmt->close();

$tecnicas = [];
while ($row = $result_tec->fetch_assoc()) {
    $tid = $row['tec_id'];
    if (!isset($tecnicas[$tid])) {
        $tecnicas[$tid] = ['id'=>$tid,'nome'=>$row['nome_tecnica'],'descricao'=>$row['descricao_tecnica'],'jutsus'=>[]];
    }
    $tecnicas[$tid]['jutsus'][] = [
        'id'=>$row['jut_id'],'nome'=>$row['nome_jutsu'],
        'descricao'=>$row['descricao_jutsu'],'custo'=>$row['custo'],'level'=>$row['level']
    ];
}

// habilidades básicas
$stmt = $conn->prepare("SELECT R_player_habilidades_basicas.id as rel_id,
    habilidades_basicas.id, habilidades_basicas.nome, habilidades_basicas.custo,
    energias.nome as energia_nome, R_player_habilidades_basicas.level
FROM R_player_habilidades_basicas
JOIN habilidades_basicas ON R_player_habilidades_basicas.id_habilidade_basica = habilidades_basicas.id
LEFT JOIN energias ON habilidades_basicas.id_energia_custo = energias.id
WHERE R_player_habilidades_basicas.id_player = ?");
$stmt->bind_param("i",$id); $stmt->execute();
$habs_basicas = $stmt->get_result()->fetch_all(MYSQLI_ASSOC); $stmt->close();

// habilidades de classe
$stmt = $conn->prepare("SELECT R_player_habilidade_classe.id as rel_id,
    habilidades_classe.id, habilidades_classe.nome, habilidades_classe.custo,
    habilidades_classe.descricao, energias.nome as energia_nome, R_player_habilidade_classe.level
FROM R_player_habilidade_classe
JOIN habilidades_classe ON R_player_habilidade_classe.id_habilidade_classe = habilidades_classe.id
LEFT JOIN energias ON habilidades_classe.id_energia_custo = energias.id
WHERE R_player_habilidade_classe.id_player = ?");
$stmt->bind_param("i",$id); $stmt->execute();
$habs_classe = $stmt->get_result()->fetch_all(MYSQLI_ASSOC); $stmt->close();

// ── helper: botão de delete inline ───────────────────────────
function del_btn($action, $rid, $pid, $confirm) {
    echo "<form method='post' style='display:inline' onsubmit=\"return confirm('$confirm')\">";
    echo "<input type='hidden' name='action' value='$action'>";
    echo "<input type='hidden' name='rid' value='$rid'>";
    echo "<input type='hidden' name='id' value='$pid'>";
    echo "<button type='submit' class='btn-admin btn-delete' style='font-size:12px;padding:4px 10px'>Remover</button>";
    echo "</form>";
}
?>

<!-- ── CABEÇALHO DA FICHA ── -->
<div class="content"><h2>Ficha</h2></div>

<div class="content">
    <div class="fichas">
        <h2>Informações</h2>
        <?php if (is_admin()): ?>
        <div class="admin-bar" style="margin-bottom:12px">
            <a class="btn-admin btn-edit" href="ficha_form.php?id=<?= $id ?>">Editar Status / Energias / Mente</a>
        </div>
        <?php endif; ?>
        <h3>Nome: <?= htmlspecialchars($ficha["nome"]) ?></h3>
        <h3>Classe: <?= htmlspecialchars($ficha["classe"]) ?></h3>
        <h3>Efeitos: <?= htmlspecialchars($ficha["efeitos"]) ?></h3>
        <h3>Dinheiro: <?= htmlspecialchars($ficha["dinheiro"]) ?></h3>

        <!-- Títulos -->
        <h3>Títulos:</h3>
        <?php foreach ($titulos as $t): ?>
            <span style="margin-right:8px"><?= htmlspecialchars($t['titulo']) ?></span>
            <?php if (is_admin()) del_btn('del_titulo',$t['rel_id'],$id,'Remover título do player?'); ?>
        <?php endforeach; ?>
        <?php if (is_admin()): ?>
        <div class="admin-bar" style="margin-top:8px">
            <a class="btn-admin btn-add" href="ficha_add_titulo.php?id=<?= $id ?>">+ Título</a>
        </div>
        <?php endif; ?>
        <?php
        $s_inv = $conn->prepare("SELECT COUNT(*) as total FROM invocacao_base WHERE id_player = ?");
        $s_inv->bind_param("i", $id); $s_inv->execute();
        $total_inv = $s_inv->get_result()->fetch_assoc()['total']; $s_inv->close();
        ?>
        <div style="margin-top:16px">
            <h3>Invocações:
                <?php if ($total_inv > 0): ?>
                    <span style="font-size:14px;color:#888">(<?= $total_inv ?>)</span>
                <?php endif; ?>
            </h3>
            <div class="admin-bar" style="margin-top:8px">
                <a class="btn-admin btn-edit" href="invocacoes.php?player_id=<?= $id ?>">
                    <?= $total_inv > 0 ? '⚔️ Ver Invocações' : '⚔️ Gerenciar Invocações' ?>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="fichas">
        <h2>Status</h2>
        <h3>Level: <?= htmlspecialchars($ficha["level"]) ?></h3>
        <h3>Hp: <?= htmlspecialchars($ficha["hp"]) ?></h3>
        <h3>Força: <?= htmlspecialchars($ficha["forca"]) ?></h3>
        <h3>Velocidade: <?= htmlspecialchars($ficha["velocidade"]) ?></h3>
        <h3>Agilidade: <?= htmlspecialchars($ficha["agilidade"]) ?></h3>
        <h3>Durabilidade: <?= htmlspecialchars($ficha["durabilidade"]) ?></h3>
        <h3>Combate: <?= htmlspecialchars($ficha["combate"]) ?></h3>
        <h3>Experiencia: <?= htmlspecialchars($ficha["experiencia"]) ?></h3>
        <br>
        <h3>Iq: <?= htmlspecialchars($ficha["iq"]) ?></h3>
        <h3>Stamina: <?= htmlspecialchars($ficha["stamina"]) ?></h3>
        <h3>Energia: <?= htmlspecialchars($ficha["energia"]) ?></h3>
        <h3>Aura: <?= htmlspecialchars($ficha["aura"]) ?></h3>
    </div>
</div>

<div class="content">
    <div class="fichas">
        <h2>Mente</h2>
        <h3>Sanidade: <?= htmlspecialchars($ficha["sanidade"]) ?>/<?= htmlspecialchars($ficha["sanidadeMax"]) ?></h3>
        <h3>Estresse: <?= htmlspecialchars($ficha["stress"]) ?></h3>
        <h3>Traumas: <?= htmlspecialchars($ficha["traumas"]) ?></h3>
        <h3>RM: <?= htmlspecialchars($ficha["rm"]) ?></h3>
    </div>
</div>

<!-- ── ITENS ── -->
<div class="content">
    <div class="fichas">
        <h2>Itens</h2>
        <?php if (is_admin()): ?>
        <div class="admin-bar" style="margin-bottom:12px">
            <a class="btn-admin btn-add" href="ficha_add_item.php?id=<?= $id ?>">+ Adicionar Item</a>
        </div>
        <?php endif; ?>

        <?php foreach ($itensAgrupados as $rel_id => $item): ?>
            <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:8px">
                <a href="itemview.php?id=<?= $item['id'] ?>" class="ficha_link" style="flex:1">
                    <div class="ficha">
                        <h3 class="nome_ficha"><?= htmlspecialchars($item['item']) ?></h3>
                        <?php foreach ($item['encantamentos'] as $enc): ?>
                            <a href="encantamentoview.php?id=<?= $enc['id'] ?>" class="ficha_link">
                                <p><?= htmlspecialchars($enc['nome']) ?> (Lv <?= $enc['level'] ?>)</p>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </a>
                <?php if (is_admin()): ?>
                <div class="admin-bar" style="flex-direction:column;align-items:flex-end">
                    <?php del_btn('del_item',$rel_id,$id,'Remover item do player?') ?>
                </div>
                <?php endif; ?>
            </div>
            <hr>
        <?php endforeach; ?>
    </div>
</div>

<!-- ── HABILIDADES ── -->
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
                    <?php if (is_admin()) del_btn('del_estilo',$est['rel_id'],$id,'Remover estilo de luta do player?') ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
        <?php if (is_admin()): ?>
        <div class="admin-bar" style="margin-top:8px">
            <a class="btn-admin btn-add" href="ficha_add_estilo.php?id=<?= $id ?>">+ Estilo</a>
        </div>
        <?php endif; ?>

        <br>
        <!-- Encantamentos do player -->
        <h3>Encantamentos:</h3>
        <?php if (empty($encantamentos)): ?>
            <p>Sem encantamentos</p>
        <?php else: ?>
            <?php foreach ($encantamentos as $enc): ?>
                <div style="display:flex;align-items:center;gap:8px;margin-bottom:4px">
                    <a href="encantamentoview.php?id=<?= $enc['id'] ?>" class="ficha_link">
                        <p><?= htmlspecialchars($enc['encantamento']) ?> (Lv <?= $enc['level'] ?>)</p>
                    </a>
                    <?php if (is_admin()) del_btn('del_enc_player',$enc['rel_id'],$id,'Remover encantamento do player?') ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
        <?php if (is_admin()): ?>
        <div class="admin-bar" style="margin-top:8px">
            <a class="btn-admin btn-add" href="ficha_add_encantamento.php?id=<?= $id ?>">+ Encantamento</a>
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
                        <a class="btn-admin btn-edit" href="talento_form.php?player_id=<?= $id ?>&id=<?= $tal['id'] ?>">Editar</a>
                        <?php del_btn('del_talento',$tal['id'],$id,'Deletar talento?') ?>
                    </div>
                    <?php endif; ?>
                </div>
                <hr>
            <?php endforeach; ?>
        <?php endif; ?>
        <?php if (is_admin()): ?>
        <div class="admin-bar">
            <a class="btn-admin btn-add" href="talento_form.php?player_id=<?= $id ?>">+ Talento</a>
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
                    <?php if (is_admin()) del_btn('del_hab_basica',$hab['rel_id'],$id,'Remover habilidade básica do player?') ?>
                </div>
                <hr>
            <?php endforeach; ?>
        <?php endif; ?>
        <?php if (is_admin()): ?>
        <div class="admin-bar">
            <a class="btn-admin btn-add" href="ficha_add_hab_basica.php?id=<?= $id ?>">+ Habilidade Básica</a>
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
                    <?php if (is_admin()) del_btn('del_hab_classe',$hab['rel_id'],$id,'Remover habilidade de classe do player?') ?>
                </div>
                <hr>
            <?php endforeach; ?>
        <?php endif; ?>
        <?php if (is_admin()): ?>
        <div class="admin-bar">
            <a class="btn-admin btn-add" href="ficha_add_hab_classe.php?id=<?= $id ?>">+ Habilidade de Classe</a>
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
                            <a class="btn-admin btn-edit" href="tecnica_form.php?player_id=<?= $id ?>&id=<?= $tec['id'] ?>">Editar</a>
                            <?php del_btn('del_tecnica',$tec['id'],$id,'Deletar técnica e todos os seus jutsus?') ?>
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
                                <a class="btn-admin btn-edit" href="jutsu_form.php?player_id=<?= $id ?>&tec_id=<?= $tec['id'] ?>&id=<?= $jut['id'] ?>">Editar</a>
                                <?php del_btn('del_jutsu',$jut['id'],$id,'Deletar jutsu?') ?>
                            </div>
                            <?php endif; ?>
                        </div>
                        <hr>
                    <?php endforeach; ?>

                    <?php if (is_admin()): ?>
                    <div class="admin-bar" style="margin-top:8px">
                        <a class="btn-admin btn-add" href="jutsu_form.php?player_id=<?= $id ?>&tec_id=<?= $tec['id'] ?>">+ Jutsu</a>
                    </div>
                    <?php endif; ?>
                </div>
                <br>
            <?php endforeach; ?>
        <?php endif; ?>
        <?php if (is_admin()): ?>
        <div class="admin-bar">
            <a class="btn-admin btn-add" href="tecnica_form.php?player_id=<?= $id ?>">+ Técnica</a>
        </div>
        <?php endif; ?>

    </div>
</div>
</body>
</html>
