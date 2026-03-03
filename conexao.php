<?php
$server = "localhost";
$user = "root";
$pass = "988071292Luis";
$db = "siterpg";

    if ( $conn = mysqli_connect($server, $user, $pass, $db) ) {
        echo "Conectado!";
    } else {
        echo "ERRO!";
    }

    function mensagem($texto, $tipo) {
        echo "<div class='alert alert-$tipo' role='alert'>
            $texto
        </div>";
    }

    function mostra_data($data) {
        $d = explode("", $data);
        $escreve = $d[2] . "/" . $d[1] . "/" . $d[0];
        return $escreve;
    }

