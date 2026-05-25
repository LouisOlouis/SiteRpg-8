<?php
include("conexao.php");
include("header.php");

$stmt = $conn->prepare("SELECT id, encantamento FROM encantamentos");
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();

?>

<div class="StartBlog">
    <div class="Content">
        <h1>Rpg-8</h1>
        <h3>Aqui estão os encantamentos do Rpg-8</h3>
    </div>
</div>

<div class="content">
    <div class="fichas">
        <h2>encantamentos</h2>

        <?php
        while ($encantamento = $result->fetch_assoc()) {
            echo '<a href="itemview.php?id=' . $encantamento["id"] . '" class="ficha_link">';
            echo '<div class="ficha">';
            
            echo '<h3 class=nome_ficha> ' . $encantamento['encantamento'] . '</h3>';
            
            echo '</div>';
            echo '</a>';
            echo '<hr>';
        }
        ?>

    </div>
</div>

</body>
</html>