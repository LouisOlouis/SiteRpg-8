<?php 
session_start();

$USUARIO = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : null ;

$invisivel_prelogin = $USUARIO ? 'style="display: none;"' : '';
$invisivel_poslogin = $USUARIO ? '' : 'style="display: none;"';

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Rpg-8</title>
    <link rel="stylesheet" href="Style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <header class="Top">
        <div class="Container">
                <a class="title" href="index.php"><b>RPG-8</b></a>
                <div class="Perfil">
                    <a class="Login-Button" href="login.php" <?php echo $invisivel_prelogin; ?>>Login</a>
                </div>
            </div>
    </header>
<div class="StartBlog">
    <div class="Content">
        <h1>Rpg-8</h1>
        <h3>Bem vindo a pagina do Rpg-8 (feito por louis_louis)</h3>
    </div>
</div>
<div class="content">
    <div class="Content1">
        <h2>O que deseja fazer?</h2>
        <a class="Post-Button" href="fichas.php">Ver fichas</a>
    </div>
</div>
</body>
</html>