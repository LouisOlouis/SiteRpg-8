<?php
include ('conexao.php');
include ('header.php');

$invisivel_erro = 'style="display: none;"';
$mensagem = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = $_POST["nome"] ?? "";
    $senha = $_POST["senha"] ?? "";

    $stmt = $conn->prepare("SELECT id, nome, senha_hash FROM usuarios WHERE nome = ?");
    $stmt->bind_param("s", $nome);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows <= 0) {
        $invisivel_erro = '';
        $mensagem = "Usuário nao existe.";
    } else {
        $usuario = $result->fetch_assoc();
        
        if (!password_verify($senha, $usuario['senha_hash'])){
            $invisivel_erro = '';
            $mensagem = "senha incorreta";
        } else {
            $_SESSION['user_id'] = $usuario['id'];
            $_SESSION['user_name'] = $usuario['nome'];
            header('Location: index.php');
            exit();
        }
    }
}

?>
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