<?php
include("conexao.php");
include("header.php");

$id = isset($_GET['id']) ? intval($_GET['id']) : 1;

$stmt = $conn->prepare("SELECT * FROM fichas WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();

$ficha = $result->fetch_assoc();

//get class


?>

<div class="content">
    <div class="fichas">
        <h2>Ficha</h2>
        <h3>Nome: <?php echo htmlspecialchars($ficha["nome"]); ?></h3>
        <h3>Classe: <?php echo htmlspecialchars($ficha["nome"]); ?></h3>
        <h3>Efeitos: <?php echo htmlspecialchars($ficha["efeitos"]); ?></h3>
        <h3>Titulos: <?php echo htmlspecialchars($ficha["nome"]); ?></h3>
        <h3>Dinheiro: <?php echo htmlspecialchars($ficha["nome"]); ?></h3>



