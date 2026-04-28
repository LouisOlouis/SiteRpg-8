<?php
include("conexao.php");
include("header.php");

$id = isset($_GET['id']) ? intval($_GET['id']) : 1;

$stmt = $conn->prepare("SELECT
    encantamentos.encantamento, 
    encantamentos.descricao


FROM encantamentos

WHERE encantamentos.id = ?
");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();

$encantamentos = $result->fetch_assoc();

?>
<div class="content">
    <h2>Encantamento</h2>
</div>
<div class="content">
    <div class="fichas">
        <h2>Informações</h2>
        <h3>Nome: <?php echo htmlspecialchars($encantamentos["encantamento"]); ?></h3>
        <h3>Descricao:</h3>
        <h3><?php echo htmlspecialchars($encantamentos["descricao"]); ?></h3>
    </div>
</div>