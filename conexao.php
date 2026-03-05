<?php
$server = "localhost";
$user = "root";
$pass = "***REMOVED***";
$db = "siterpg";

    if ( $conn = mysqli_connect($server, $user, $pass, $db) ) {
        //echo "Conectado!";
    } else {
        error_log( mysqli_connect_error() );
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

