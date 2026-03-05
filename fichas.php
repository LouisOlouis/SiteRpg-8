<?php
include("conexao.php");
include("header.php");

$stmt = $conn->prepare("SELECT id, nome FROM fichas");
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();

?>

<div class="StartBlog">
    <div class="Content">
        <h1>Rpg-8</h1>
        <h3>Aqui estão as fichas dos personagens do Rpg-8</h3>
    </div>
</div>

<div class="content">
    <div class="fichas">
        <h2>Fichas</h2>

        <?php
        while ($ficha = $result->fetch_assoc()) {
            echo '<a href="fichaview.php?id=' . $ficha["id"] . '" class="ficha_link">';
            echo '<div class="ficha">';
            
            echo '<h3 class=nome_ficha> ' . $ficha['nome'] . '</h3>';
            
            echo '</div>';
            echo '</a>';
            echo '<hr>';
        }
        ?>

    </div>
</div>

</body>
</html>