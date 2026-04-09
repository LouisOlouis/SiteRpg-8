<?php
include("conexao.php");
include("header.php");

$id = isset($_GET['id']) ? intval($_GET['id']) : 1;

$stmt = $conn->prepare("SELECT
    itens.item, 
    itens.descricao,
    raridades.raridade


FROM itens

JOIN raridades ON itens.id_raridade = raridades.id

WHERE itens.id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();

$item = $result->fetch_assoc();

?>
<div class="content">
    <h2>Item</h2>
</div>
<div class="content">
    <div class="fichas">
        <h2>Informações</h2>
        <h3>Nome: <?php echo htmlspecialchars($item["item"]); ?></h3>
        <h3>Raridade: <?php echo htmlspecialchars($item["raridade"]); ?></h3>
        <h3>Descricao:</h3>
        <h3><?php echo htmlspecialchars($item["descricao"]); ?></h3>
    </div>
</div>