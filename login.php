<?php
include ('conexao.php');
session_start();

$USUARIO = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : null ;

$invisivel_prelogin = $USUARIO ? 'style="display: none;"' : '';
$invisivel_poslogin = $USUARIO ? '' : 'style="display: none;"';

$invisivel_erro = 'style="display: none;"';
$mensagem = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = $_POST["nome"] ?? "";
    $senha = $_POST["senha"] ?? "";

    $stmt = $conn->prepare("SELECT nome FROM usuarios WHERE nome = ?");
    $stmt->bind_param("s", $nome);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows <= 0) {
        echo "Usuário nao existe.";
    } else {
        $usuario = $result->fetch_assoc();
        
        if (!password_verify($senha, $usuario['senha_hash'])){
            echo "senha incorreta";
        } else {
            echo "liberar login";
        }
    }


}

?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>SiteRpg-Login</title>
        <link rel="stylesheet" href="Style.css?v=3.0">
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
    <div class="form">
        <form method="post" >
            <h2>Login</h2>
            <h3>Digite seu nome</h3>
            <input type="text" name="nome" autocomplete="off" required>
            <h3>Digite sua senha</h3>
            <input type="password" name="senha" autocomplete="off" required>
            <br>
            
            <h4 class="erro" $invisivel_erro><?= $mensagem?></h4>

            <button type="submit">Logar</button>
        </form>
        <h4>Não possui conta?<a href="register.php">Registrar</a></h4>

    </div>


    </body>
</html>