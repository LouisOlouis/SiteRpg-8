<?php
include("conexao.php");
include("header.php");

$stmt = $conn->prepare("SELECT id, item FROM itens");
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();

?>

<div class="StartBlog">
    <div class="Content">
        <h1>Rpg-8</h1>
        <h3>Aqui estão os itens do Rpg-8</h3>
    </div>
</div>

<div class="content">
    <div class="fichas">
        <h2>Itens</h2>

        <?php
        while ($item = $result->fetch_assoc()) {
            echo '<a href="itemview.php?id=' . $item["id"] . '" class="ficha_link">';
            echo '<div class="ficha">';
            
            echo '<h3 class=nome_ficha> ' . $item['item'] . '</h3>';
            
            echo '</div>';
            echo '</a>';
            echo '<hr>';
        }
        ?>

    </div>
</div>

</body>
</html>