<?php
include_once('Conexao.php');

if(isset($_POST['enviar'])) {
    
    $nome_usuario = $_POST['nome'];
    $email_usuario = $_POST['email'];
    $rm_usuario = $_POST['rm'];
    $etec_usuario = $_POST['etec'];
    $telefone_usuario = $_POST['telefone'];
    $senha_usuario = $_POST['senha'];

    $result = mysqli_query($conexao, "INSERT INTO usuarios (nome_usuario, email_usuario, rm_usuario, etec_usuario, telefone_usuario, senha_usuario) 
    VALUES ('$nome_usuario', '$email_usuario', '$rm_usuario', '$etec_usuario', '$telefone_usuario', '$senha_usuario')");

    if ($result) {
        header("Location: Login.php"); 
        exit();
    } else {
        echo "Erro ao cadastrar: " . mysqli_error($conexao);
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;600&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
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
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            width: 30%;
            margin-top: 120px;
            font-family: 'Lato', sans-serif;
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
            text-decoration: none;
            font-size: 16px;
        }

        .btn:hover {
            background-color: #003d82;
        }

        .btn-login {
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

        .btn-login:hover {
            background-color: #003d82;
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

    </style>
</head>
<body>

    <header>
        <div class="LogoDiv">
            <img class="LogoEtec" src="../imagens/Etec_Logo.webp">
        </div>
    </header>

<div class="container">
    <form action="Cadastro.php" method="POST">
        <h2> Cadastro </h2>
        <div>
            <label for="nome" class="esconder">Nome</label>
            <input type="text" id="nome" name="nome" placeholder="Nome:" required>
        </div>

        <div>
            <label for="email" class="esconder">Email Institucional</label>
            <input type="email" id="email" name="email" placeholder="Email Institucional:" required>
        </div>

        <div>
            <label for="rm" class="esconder">RM</label>
            <input type="number" id="rm" name="rm" placeholder="RM:" min="10000" max="99999" onkeydown="bloquearE(event)" required>
        </div>

        <div>
            <label for="etec" class="esconder">ID da ETEC</label>
            <input type="number" id="etec" name="etec" placeholder="ID da ETEC:" min="100" max="999" onkeydown="bloquearE(event)" required>
        </div>

        <div>
            <label for="telefone" class="esconder">Telefone</label>
            <input type="tel" id="telefone" name="telefone" placeholder="Telefone:" required>
        </div>

        <div>
            <label for="senha" class="esconder">Senha</label>
            <input type="password" id="senha" name="senha" placeholder="Senha:" required>
        </div>
        <br>
        <button class="btn" type="submit" name="enviar" id="enviar">Cadastrar</button><br><br>
        <a href="Login.php" class="btn-login">Já tem uma conta ? Faça o Login!</a>
    </form>
</div>

    <script>

function bloquearE(event) {
    if (event.key === "e" || event.key === "E") {
        event.preventDefault();
    }
}

    </script>
</body>
</html>
