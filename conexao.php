<?php
require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$host = $_ENV['DB_HOST'];
$user = $_ENV['DB_USER'];
$pass = $_ENV['DB_PASSWORD'];
$db   = $_ENV['DB_NAME'];

<<<<<<< HEAD
    if ( $conn = mysqli_connect($host, $user, $pass, $db) ) {
=======
    if ( $conn = mysqli_connect($server, $user, $pass, $db) ) {
>>>>>>> 3160879d1b7967ac902b8ddcc9501ad489b32d9d
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

