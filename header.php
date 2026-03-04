<?php
session_start();


?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>SiteRPG</title>
    <link rel="stylesheet" href="Style.css?v=3.0">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<header class="Top">
    <div class="Container">
        <a class="title" href="index.php"><b>RPG-8</b></a>
        <div class="Perfil">
        <?php
        if (isset($_SESSION["user_id"])) {
            echo "<a class='Nome'>" . htmlspecialchars($_SESSION['user_name']) . "</a>";
        } else {
            echo '<a class="Login-Button" href="login.php">Login</a>';
        }
        ?>
        </div>
    </div>
</header>
