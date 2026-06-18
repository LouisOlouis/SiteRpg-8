<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Executor SQL</title>
</head>
<body>

<h2>Executar SQL</h2>

<form method="POST">
    <textarea name="query" rows="10" cols="80"></textarea><br><br>
    <button type="submit">Executar</button>
</form>

<?php

if(isset($_POST['query'])){

    $conexao = mysqli_connect(
        "localhost",
        "root",
        "",
        "meubanco"
    );

    $query = $_POST['query'];

    $resultado = mysqli_query($conexao, $query);

    if($resultado){

        echo "<h3>Query executada com sucesso!</h3>";

        if($resultado instanceof mysqli_result){

            echo "<table border='1'>";

            while($linha = mysqli_fetch_assoc($resultado)){

                echo "<tr>";

                foreach($linha as $valor){
                    echo "<td>$valor</td>";
                }

                echo "</tr>";
            }

            echo "</table>";
        }

    }else{
        echo "<h3>Erro:</h3>";
        echo mysqli_error($conexao);
    }

    mysqli_close($conexao);
}

?>

</body>
</html>