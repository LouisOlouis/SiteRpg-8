<?php
include("conexao.php");
include("header.php");

$stmt = $conn->prepare("SELECT id, nome FROM estilos_luta");
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();

?>

<div class="StartBlog">
    <div class="Content">
        <h1>Rpg-8</h1>
        <h3>Aqui estão os estilos de luta do Rpg-8</h3>
    </div>
</div>

<div class="content">
    <div class="fichas">
        <h2>Estilos de Luta</h2>

        <?php
        while ($estilo = $result->fetch_assoc()) {
            echo '<a href="itemview.php?id=' . $estilo["id"] . '" class="ficha_link">';
            echo '<div class="ficha">';
            
            echo '<h3 class=nome_ficha> ' . $estilo['nome'] . '</h3>';
            
            echo '</div>';
            echo '</a>';
            echo '<hr>';
        }
        ?>

    </div>
</div>

</body>
</html>