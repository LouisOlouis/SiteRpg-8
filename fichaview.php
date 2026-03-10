<?php
include("conexao.php");
include("header.php");

$id = isset($_GET['id']) ? intval($_GET['id']) : 1;

$stmt = $conn->prepare("SELECT 
    player.*,
    classes.classe AS classe,
    GROUP_CONCAT(titulos.titulo SEPARATOR '| ') AS titulos
FROM player
JOIN classes 
    ON player.id_classe = classes.id
LEFT JOIN R_player_titulo 
    ON player.id = R_player_titulo.id_player
LEFT JOIN titulos 
    ON R_player_titulo.id_titulo = titulos.id
WHERE player.id = ?
GROUP BY player.id, classes.classe;");

$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();

$ficha = $result->fetch_assoc();



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



