<?php
include("conexao.php");
include("header.php");

$id = isset($_GET['id']) ? intval($_GET['id']) : 1;
//fichas
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

//itens
$stmt = $conn->prepare("SELECT
    itens.id,
    itens.item,

    R_item_player_encantamento.level,
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
    $id = $row['id'];

    if (!isset($itensAgrupados[$id])) {
        $itensAgrupados[$id] = [
            'item' => $row['item'],
            'encantamentos' => []
        ];
    }

    if ($row['encantamento']) {
        $itensAgrupados[$id]['encantamentos'][] = [
            'nome' => $row['encantamento'],
            'level' => $row['level']
        ];
    }
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

        <?php
        foreach ($itensAgrupados as $id => $item) {
            echo '<a href="itemview.php?id=' . $id . '" class="ficha_link">';
            echo '<div class="ficha">';
            
            echo '<h3 class=nome_ficha>' . $item['item'] . '</h3>';

            foreach ($item['encantamentos'] as $enc) {
                echo '<p>' . $enc['nome'] . ' (Lv ' . $enc['level'] . ')</p>';
            }

            echo '</div>';
            echo '</a>';
            echo '<hr>';
        }
        ?>

    </div>
</div>

<div class="content">
    <div class="fichas">
        <h2>Poderes:</h2>
