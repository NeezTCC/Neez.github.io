<?php
include_once('Conexao.php');
session_start();

$erro = "";

if(isset($_POST['login'])) {
    $rm_usuario = $_POST['rm'];
    $senha_usuario = $_POST['senha'];

    $query = "SELECT id_usuario, nivel FROM usuarios WHERE rm_usuario = '$rm_usuario' AND senha_usuario = '$senha_usuario'";
    $result = mysqli_query($conexao, $query);

    if(mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        $_SESSION['usuario'] = $user['id_usuario'];  // Armazena o id do usuário
        $_SESSION['nivel'] = $user['nivel'];  // Armazena o nível do usuário        

        header("Location: MenuPrincipal.php");
        exit();
    } else {
        $erro = "RM ou Senha incorretos";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;600&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #001F3F;
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        header {
            background-color: #000;
            padding: 20px 0;
            text-align: left;
            width: 100%;
            display: flex;
            align-items: center;
            position: absolute;
            top: 0;
            left: 0;
        }

        .LogoDiv {
            width: 250px;
            height: 70px;
            background-color: #d9d9d9;
            border-top-right-radius: 40px;
            border-bottom-right-radius: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-left: 0;
        }

        .LogoEtec {
            max-width: 80%;
            max-height: 80%;
            background-color: #d9d9d9;
        }

        .container {
            background: #002F5F;
            padding: 20px;
            border-radius: 10px;
            width: 30%;
            margin-top: 120px;
            text-align: center;
        }

        h2 {
            text-align: center;
        }

        input {
            width: calc(100% - 20px);
            padding: 10px;
            margin: 5px 0;
            border: none;
            border-radius: 5px;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        .btn {
            background-color: #0056b3;
            color: white;
            border: none;
            padding: 10px;
            width: 100%;
            cursor: pointer;
            border-radius: 5px;
            font-size: 16px;
        }

        .btn:hover {
            background-color: #003d82;
        }

        .erro {
            color: red;
            margin-top: 10px;
            font-size: 14px;
            font-weight: bold;
        }

        .esconder {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            border: 0;
        }

        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type="number"] {
            -moz-appearance: textfield;
        }

        .btn-cadastro {
            background-color: #0056b3; 
            color: white;
            border: none;
            padding: 10px;
            width: 95%;
            cursor: pointer;
            border-radius: 5px;
            text-align: center;
            display: block;
            text-decoration: none;
            display: inline-block; 
            font-size: 16px; 
            line-height: normal; 
        }

        .btn-cadastro:hover {
            background-color: #003d82;
        }

    </style>
</head>
<body>

<header>
    <div class="LogoDiv">
        <img class="LogoEtec" src="../imagens/Etec_Logo.webp">
    </div>
</header>

<div class="container">
    <form action="Login.php" method="POST">
        <h2>Login</h2>

        <div>
            <label for="rm" class="esconder">RM</label>
            <input type="number" id="rm" name="rm" placeholder="RM:" min="10000" max="99999" required>
        </div>

        <div>
            <label for="senha" class="esconder">Senha</label>
            <input type="password" id="senha" name="senha" placeholder="Senha:" required>
        </div>

        <br>
        <button class="btn" type="submit" name="login">Entrar</button><br><br>
        <a href="Cadastro.php" class="btn-cadastro">Não tem uma conta ? Faça uma agora!</a>

        <?php if($erro): ?>
            <p class="erro"><?php echo $erro; ?></p>
        <?php endif; ?>
    </form>
</div>

</body>
</html>