<?php
include("conexao.php");
include("header.php");

$id = isset($_GET['id']) ? intval($_GET['id']) : 1;

// ficha principal
$stmt = $conn->prepare("SELECT 
    player_base.nome,
    player_base.efeitos,

    classes.classe,

    player_dinheiro.dinheiro,
    player_dinheiro.fragmento,

    player_status.level,
    player_status.hp,
    player_status.forca,
    player_status.velocidade,
    player_status.agilidade,
    player_status.durabilidade,
    player_status.combate,
    player_status.experiencia,

    player_energias.iq,
    player_energias.stamina,
    player_energias.energia,
    player_energias.aura,

    player_mente.sanidade,
    player_mente.sanidadeMax,
    player_mente.stress,
    player_mente.traumas,
    player_mente.rm,

    (
        SELECT GROUP_CONCAT(t.titulo SEPARATOR '| ')
        FROM R_player_titulo rpt
        JOIN titulos t ON rpt.id_titulo = t.id
        WHERE rpt.id_player = player_base.id
    ) AS titulos

FROM player_base
JOIN classes ON player_base.id_classe = classes.id

LEFT JOIN player_dinheiro ON player_base.id = player_dinheiro.id_player
LEFT JOIN player_status ON player_base.id = player_status.id_player
LEFT JOIN player_energias ON player_base.id = player_energias.id_player
LEFT JOIN player_mente ON player_base.id = player_mente.id_player

WHERE player_base.id = ?");

$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$ficha = $result->fetch_assoc();
$stmt->close();

// itens
$stmt = $conn->prepare("SELECT
    itens.id as id_itens,
    itens.item,

    R_item_player_encantamento.level,
    encantamentos.id as id_encantamentos,
    encantamentos.encantamento

    FROM R_player_item

    JOIN itens ON R_player_item.id_item = itens.id

    LEFT JOIN R_item_player_encantamento ON R_player_item.id = R_item_player_encantamento.id_item_player

    LEFT JOIN encantamentos ON R_item_player_encantamento.id_encantamentos = encantamentos.id

    WHERE R_player_item.id_player = ?");

$stmt->bind_param("i", $id);
$stmt->execute();
$result_itens = $stmt->get_result();
$stmt->close();

$itensAgrupados = [];

while ($row = $result_itens->fetch_assoc()) {
    if (!isset($itensAgrupados[$row['id_itens']])) {
        $itensAgrupados[$row['id_itens']] = [
            'item' => $row['item'],
            'encantamentos' => []
        ];
    }

    if ($row['encantamento']) {
        $itensAgrupados[$row['id_itens']]['encantamentos'][] = [
            'id'    => $row['id_encantamentos'],
            'nome'  => $row['encantamento'],
            'level' => $row['level']
        ];
    }
}

// estilo de luta
$stmt = $conn->prepare("SELECT
    estilos_luta.nome
    FROM R_player_estiloluta
    JOIN estilos_luta ON R_player_estiloluta.id_estiloluta = estilos_luta.id
    WHERE id_player = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result_estiloluta = $stmt->get_result();
$estiloluta = $result_estiloluta->fetch_assoc();
$stmt->close();

// encantamentos do player
$stmt = $conn->prepare("SELECT
    encantamentos.id,
    encantamentos.encantamento,
    r_player_encantamento.level
    FROM r_player_encantamento
    JOIN encantamentos ON r_player_encantamento.id_encantamentos = encantamentos.id
    WHERE r_player_encantamento.id_player = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result_encantamentos = $stmt->get_result();
$stmt->close();

$encantamentos = [];
while ($row = $result_encantamentos->fetch_assoc()) {
    if (!isset($encantamentos[$row['id']])) {
        $encantamentos[$row['id']] = [
            'nome'  => $row['encantamento'],
            'level' => $row['level']
        ];
    }
}

// talentos
$stmt = $conn->prepare("SELECT
    player_talentos.nome,
    player_talentos.descricao
    FROM player_talentos
    WHERE id_player = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result_talentos = $stmt->get_result();
$talentos = $result_talentos->fetch_assoc();
$stmt->close();

// técnicas e jutsus
$stmt = $conn->prepare("SELECT
    player_tecnicas.nome as nome_tecnica,
    player_tecnicas.descricao as descricao_tecnica,

    player_jutsus.nome as nome_jutsu,
    player_jutsus.custo,
    player_jutsus.level,
    player_jutsus.descricao as descricao_jutsu

    FROM player_tecnicas
    JOIN player_jutsus ON player_tecnicas.id = player_jutsus.id_tecnica
    WHERE player_tecnicas.id_player = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result_tecnicas = $stmt->get_result();
$stmt->close();

$tecnicas = [];
while ($row = $result_tecnicas->fetch_assoc()) {
    if (!isset($tecnicas[$row['nome_tecnica']])) {
        $tecnicas[$row['nome_tecnica']] = [
            'descricao' => $row['descricao_tecnica'],
            'jutsus'    => []
        ];
    }
    $tecnicas[$row['nome_tecnica']]['jutsus'][] = [
        'nome'     => $row['nome_jutsu'],
        'descricao'=> $row['descricao_jutsu'],
        'custo'    => $row['custo'],
        'level'    => $row['level']
    ];
}

// habilidades básicas
$stmt = $conn->prepare("SELECT
    habilidades_basicas.id,
    habilidades_basicas.nome,
    habilidades_basicas.custo,
    habilidades_basicas.id_energia_custo,
    energias.nome as energia_nome,
    R_player_habilidades_basicas.level

    FROM R_player_habilidades_basicas
    JOIN habilidades_basicas ON R_player_habilidades_basicas.id_habilidade_basica = habilidades_basicas.id
    LEFT JOIN energias ON habilidades_basicas.id_energia_custo = energias.id
    WHERE R_player_habilidades_basicas.id_player = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result_hab_basicas = $stmt->get_result();
$stmt->close();

$habilidades_basicas = [];
while ($row = $result_hab_basicas->fetch_assoc()) {
    $habilidades_basicas[] = [
        'id'         => $row['id'],
        'nome'       => $row['nome'],
        'custo'      => $row['custo'],
        'energia'    => $row['energia_nome'],
        'level'      => $row['level']
    ];
}

// habilidades de classe
$stmt = $conn->prepare("SELECT
    habilidades_classe.id,
    habilidades_classe.nome,
    habilidades_classe.custo,
    habilidades_classe.descricao,
    energias.nome as energia_nome,
    R_player_habilidade_classe.level

    FROM R_player_habilidade_classe
    JOIN habilidades_classe ON R_player_habilidade_classe.id_habilidade_classe = habilidades_classe.id
    LEFT JOIN energias ON habilidades_classe.id_energia_custo = energias.id
    WHERE R_player_habilidade_classe.id_player = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result_hab_classe = $stmt->get_result();
$stmt->close();

$habilidades_classe = [];
while ($row = $result_hab_classe->fetch_assoc()) {
    $habilidades_classe[] = [
        'id'      => $row['id'],
        'nome'    => $row['nome'],
        'custo'   => $row['custo'],
        'energia' => $row['energia_nome'],
        'descricao'=> $row['descricao'],
        'level'   => $row['level']
    ];
}
?>

<div class="content">
    <h2>Ficha</h2>
</div>

<div class="content">
    <div class="fichas">
        <h2>Informações</h2>
        <h3>Nome: <?php echo htmlspecialchars($ficha["nome"]); ?></h3>
        <h3>Classe: <?php echo htmlspecialchars($ficha["classe"]); ?></h3>
        <h3>Efeitos: <?php echo htmlspecialchars($ficha["efeitos"]); ?></h3>
        <h3>Titulos: <?php echo htmlspecialchars($ficha["titulos"]); ?></h3>
        <h3>Dinheiro: <?php echo htmlspecialchars($ficha["dinheiro"]); ?></h3>
    </div>
</div>

<div class="content">
    <div class="fichas">
        <h2>Status</h2>
        <h3>Level: <?php echo htmlspecialchars($ficha["level"]); ?></h3>
        <h3>Hp: <?php echo htmlspecialchars($ficha["hp"]); ?></h3>
        <h3>Força: <?php echo htmlspecialchars($ficha["forca"]); ?></h3>
        <h3>Velocidade: <?php echo htmlspecialchars($ficha["velocidade"]); ?></h3>
        <h3>Agilidade: <?php echo htmlspecialchars($ficha["agilidade"]); ?></h3>
        <h3>Durabilidade: <?php echo htmlspecialchars($ficha["durabilidade"]); ?></h3>
        <h3>Combate: <?php echo htmlspecialchars($ficha["combate"]); ?></h3>
        <h3>Experiencia: <?php echo htmlspecialchars($ficha["experiencia"]); ?></h3>
        <br>
        <h3>Iq: <?php echo htmlspecialchars($ficha["iq"]); ?></h3>
        <h3>Stamina: <?php echo htmlspecialchars($ficha["stamina"]); ?></h3>
        <h3>Energia: <?php echo htmlspecialchars($ficha["energia"]); ?></h3>
        <h3>Aura: <?php echo htmlspecialchars($ficha["aura"]); ?></h3>
    </div>
</div>

<div class="content">
    <div class="fichas">
        <h2>Mente</h2>
        <h3>Sanidade: <?php echo htmlspecialchars($ficha["sanidade"]); ?>/<?php echo htmlspecialchars($ficha["sanidadeMax"]); ?></h3>
        <h3>Estresse: <?php echo htmlspecialchars($ficha["stress"]); ?></h3>
        <h3>Traumas: <?php echo htmlspecialchars($ficha["traumas"]); ?></h3>
        <h3>RM: <?php echo htmlspecialchars($ficha["rm"]); ?></h3>
    </div>
</div>

<div class="content">
    <div class="fichas">
        <h2>Itens</h2>
        <?php foreach ($itensAgrupados as $id_item => $item): ?>
            <a href="itemview.php?id=<?php echo $id_item; ?>" class="ficha_link">
                <div class="ficha">
                    <h3 class="nome_ficha"><?php echo htmlspecialchars($item['item']); ?></h3>
                    <?php foreach ($item['encantamentos'] as $enc): ?>
                        <a href="encantamentoview.php?id=<?php echo $enc['id']; ?>" class="ficha_link">
                            <p><?php echo htmlspecialchars($enc['nome']); ?> (Lv <?php echo $enc['level']; ?>)</p>
                        </a>
                    <?php endforeach; ?>
                </div>
            </a>
            <hr>
        <?php endforeach; ?>
    </div>
</div>

<div class="content">
    <div class="fichas">
        <h2>Habilidades</h2>

        <h3>Estilo de Luta: <?php echo htmlspecialchars($estiloluta["nome"] ?? "Sem estilo"); ?></h3>

        <h3>Encantamentos:</h3>
        <?php if (empty($encantamentos)): ?>
            <h3>Sem encantamentos</h3>
        <?php else: ?>
            <?php foreach ($encantamentos as $id_enc => $enc): ?>
                <a href="encantamentoview.php?id=<?php echo $id_enc; ?>" class="ficha_link">
                    <div class="ficha">
                        <p><?php echo htmlspecialchars($enc['nome']); ?> (Lv <?php echo $enc['level']; ?>)</p>
                    </div>
                </a>
                <hr>
            <?php endforeach; ?>
            <br>
        <?php endif; ?>

        <?php if ($talentos != null): ?>
            <h3>Talentos: <?php echo htmlspecialchars($talentos['nome']); ?></h3>
            <p><?php echo htmlspecialchars($talentos['descricao']); ?></p>
        <?php else: ?>
            <h3>Talentos: Sem Talentos</h3>
        <?php endif; ?>

        <br>
        <h3>Habilidades Básicas:</h3>
        <?php if (empty($habilidades_basicas)): ?>
            <p>Sem habilidades básicas</p>
        <?php else: ?>
            <?php foreach ($habilidades_basicas as $hab): ?>
                <div class="ficha">
                    <p><strong><?php echo htmlspecialchars($hab['nome']); ?></strong> (Lv <?php echo htmlspecialchars($hab['level']); ?>)</p>
                    <?php if ($hab['custo'] !== null): ?>
                        <p>Custo: <?php echo htmlspecialchars($hab['custo']); ?> <?php echo htmlspecialchars($hab['energia'] ?? ''); ?></p>
                    <?php endif; ?>
                </div>
                <hr>
            <?php endforeach; ?>
        <?php endif; ?>

        <br>
        <h3>Habilidades de Classe:</h3>
        <?php if (empty($habilidades_classe)): ?>
            <p>Sem habilidades de classe</p>
        <?php else: ?>
            <?php foreach ($habilidades_classe as $hab): ?>
                <div class="ficha">
                    <p><strong><?php echo htmlspecialchars($hab['nome']); ?></strong> (Lv <?php echo htmlspecialchars($hab['level']); ?>)</p>
                    <?php if ($hab['custo'] !== null): ?>
                        <p>Custo: <?php echo htmlspecialchars($hab['custo']); ?> <?php echo htmlspecialchars($hab['energia'] ?? ''); ?></p>
                    <?php endif; ?>
                    <?php if ($hab['descricao']): ?>
                        <p><?php echo htmlspecialchars($hab['descricao']); ?></p>
                    <?php endif; ?>
                </div>
                <hr>
            <?php endforeach; ?>
        <?php endif; ?>

        <br>
        <h3>Tecnicas:</h3>
        <?php if (empty($tecnicas)): ?>
            <h3>Sem técnicas</h3>
        <?php else: ?>
            <?php foreach ($tecnicas as $nome_tecnica => $tecnica): ?>
                <div class="ficha">
                    <h3><?php echo htmlspecialchars($nome_tecnica); ?></h3>
                    <p><?php echo htmlspecialchars($tecnica['descricao']); ?></p>
                    <h4>Jutsus:</h4>
                    <?php foreach ($tecnica['jutsus'] as $jutsu): ?>
                        <div class="subficha">
                            <p><strong><?php echo htmlspecialchars($jutsu['nome']); ?></strong></p>
                            <p>Level: <?php echo htmlspecialchars($jutsu['level']); ?></p>
                            <p>Custo: <?php echo htmlspecialchars($jutsu['custo'] ?? '—'); ?></p>
                            <p><?php echo htmlspecialchars($jutsu['descricao']); ?></p>
                        </div>
                        <hr>
                    <?php endforeach; ?>
                </div>
                <br>
            <?php endforeach; ?>
        <?php endif; ?>

    </div>
</div>