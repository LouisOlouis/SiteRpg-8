<?php
include ('conexao.php');
include("header.php");

$invisivel_erro = 'style="display: none;"';
$mensagem = '';

function validarSenha($senha) {
    if (strlen($senha) < 8) {
        return "A senha deve ter pelo menos 8 caracteres.";
    }
    if (!preg_match("/[a-z]/", $senha)) {
        return "A senha deve conter pelo menos uma letra minúscula.";
    }
    if (!preg_match("/[A-Z]/", $senha)) {
        return "A senha deve conter pelo menos uma letra maiúscula.";
    }
    if (!preg_match("/[0-9]/", $senha)) {
        return "A senha deve conter pelo menos um número.";
    }
    return true;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = $_POST["nome"] ?? "";
    $senha = $_POST["senha"] ?? "";
    $senha2 = $_POST["senha2"] ?? "";

    $stmt = $conn->prepare("SELECT nome FROM usuarios WHERE nome = ?");
    $stmt->bind_param("s", $nome);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    if ($result->num_rows > 0) {
        $invisivel_erro = '';
        $mensagem = "Ja existe um usuario com esse nome.";
    } elseif (strlen($nome) < 4) {
        $invisivel_erro = '';
        $mensagem = "o nome presisa ter mais de 4 caracteres";
    } elseif ($senha !== $senha2) {
        $invisivel_erro = '';
        $mensagem = "Confirme sua senha novamente";
    } elseif (($resultadoSenha = validarSenha($senha)) !== true) {
        $invisivel_erro = '';
        $mensagem = $resultadoSenha;
    } else {
        $hash_senha = password_hash($senha, PASSWORD_DEFAULT);

        $stmt = $conn->prepare('INSERT INTO usuarios (nome, senha_hash) VALUES ( ?, ?)');
        $stmt->bind_param("ss", $nome, $hash_senha);
        if ($stmt->execute()) {
            $id = $conn->insert_id;
            $stmt->close();
            $_SESSION['user_id'] = $id;
            $_SESSION['user_name'] = $nome;
            header('Location: index.php');
            exit();
        } else {
            $invisivel_erro = '';
            $mensagem = "Erro ao registrar.";
        }
    }



}

?>
<div class="form">
    <form method="post">
        <h2>Registrar</h2>
        <h3>Digite seu nome</h3>
        <input type="text" name="nome" autocomplete="off" required>
        <h3>Digite sua senha</h3>
        <input type="password" name="senha" autocomplete="off" required>
        <h3>Confirme sua senha</h3>
        <input type="password" name="senha2" autocomplete="off" required>
        <br>
        <h4 class="erro" $invisivel_erro><?= $mensagem?></h4>
        <button type="submit">Registrar</button>
    </form>
    <br>
    <h4>Ja possui conta?<a href="login.php">Logar</a></h4>

</div>
</body>
</html>