<?php
    include_once('Conexao.php');
    session_start();

    if ($_SESSION['nivel'] != 1 && $_SESSION['nivel'] != 2 && $_SESSION['nivel'] != 3) {
        header("Location: login.php"); 
        exit();
    }
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Principal</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #001F3F;
            color: white;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #000;
            width: 100%;
            display: flex;
            align-items: center;
            position: fixed;
            top: 0;
            left: 0;
            padding: 20px 0px;
        }

        .LogoDiv {
            width: 250px;
            height: 80px;
            background-color: #d9d9d9;
            border-top-right-radius: 40px;
            border-bottom-right-radius: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .LogoEtec {
            max-width: 80%;
            max-height: 80%;
            background-color: #d9d9d9;
        }

        .nav-container {
            flex-grow: 1;
            display: flex;
            justify-content: center;
        }

        .nav-links {
            display: flex;
            gap: 80px;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            font-size: 18px;
            padding: 5px 10px;
            position: relative;
        }

        .nav-links a::after {
            content: "";
            position: absolute;
            right: -40px;
            top: 50%;
            transform: translateY(-50%);
            width: 1px;
            height: 20px;
            background-color: white;
        }

        .nav-links a:last-child::after {
            display: none;
        }

        .nav-links a:hover {
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 5px;
        }

        .profile-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: gray;
            cursor: pointer;
            margin-right: 40px;
        }

        .container {
            max-width: 900px;
            margin: 120px auto 50px;
            padding: 20px;
        }

        .info-section {
            display: flex;
            align-items: center;
            margin-bottom: 40px;
        }

        .info-section img {
            width: 40%;
            height: auto;
            border-radius: 10px;
        }

        .info-text {
            width: 55%;
            padding: 20px;
            background-color: #002F5F;
            border-radius: 10px;
        }

        .info-section:nth-child(even) {
            flex-direction: row-reverse;
        }

        footer {
            background-color: #000;
            text-align: center;
            padding: 10px;
            font-size: 14px;
            margin-top: 40px;
        }

        .post-actions {
            margin-top: 10px;
        }

        .post-actions a {
            color: white;
            text-decoration: none;
            margin-right: 15px;
            background-color: #007BFF;
            padding: 5px 10px;
            border-radius: 5px;
        }

        .post-actions a:hover {
            background-color: #0056b3;
        }

        .create-post {
            margin-bottom: 20px;
            padding: 20px;
            background-color: #002F5F;
            border-radius: 10px;
        }

        .create-post input, .create-post textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        .create-post button {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
        }

        .create-post button:hover {
            background-color: #218838;
        }

    </style>
</head>
<body>

<header>
    <div class="LogoDiv">
        <img class="LogoEtec" src="../imagens/Etec_Logo.webp" alt="Logo da Etec">
    </div>
    <div class="nav-container">
        <div class="nav-links">
            <a href="Posts.php">Posts</a>
            <a href="#">Vídeos</a>
            <a href="#">Uploads</a>
        </div>
    </div>
    <a href="Perfil.php">
    <img class="profile-icon" src="../imagens/FotoPerfilGen.jpg" alt="Perfil" style="width: 50px; height: 50px; border-radius: 50%;">
</a>
</header>

<div class="container">
    <?php if ($_SESSION['nivel'] == 2): ?>
        <div class="create-post">
            <h2>Criar Nova Postagem</h2>
            <form action="CriarPostagem.php" method="POST" enctype="multipart/form-data">
                <input type="text" name="titulo" placeholder="Título" required><br>
                <textarea name="descricao" placeholder="Descrição" required></textarea><br>
                <input type="file" name="imagem" accept="image/*" required><br>
                <button type="submit">Criar Postagem</button>
            </form>
        </div>
    <?php endif; ?>

    <?php
        $query = "SELECT * FROM postagens ORDER BY data_criacao DESC";
        $result = mysqli_query($conexao, $query);

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<div class='info-section'>";
            echo "<img src='uploads/" . $row['imagem'] . "' alt='" . $row['titulo'] . "'>";
            echo "<div class='info-text'>";
            echo "<h2>" . $row['titulo'] . "</h2>";
            echo "<p>" . $row['descricao'] . "</p>";

            if ($_SESSION['nivel'] == 2) { 
                echo "<div class='post-actions'>";
                echo "<a href='EditarPostagem.php?id=" . $row['id'] . "'>Editar</a>";
                echo "<a href='ExcluirPostagem.php?id=" . $row['id'] . "'>Excluir</a>";
                echo "</div>";
            }

            echo "</div>";
            echo "</div>";
        }
    ?>
</div>

<footer>
    &copy; 2025, Eduardo Enrique Casimiro Silva e Nicolas Gabriel Morales Porto - Todos os direitos reservados.
</footer>

</body>
</html>