<?php
session_start();
require_once("Conexao.php");

// Verificar se o usuário está logado e tem permissão para acessar a página
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

// Dados do usuário
$id_usuario = $_SESSION['usuario'];

// Buscar informações sobre o usuário
$query = "SELECT * FROM usuarios WHERE id_usuario = ?";
$stmt = $conexao->prepare($query);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();
$usuario = $result->fetch_assoc();

// Verificar o nível do usuário
$nivel_usuario = $usuario['nivel'];

// Verificar se o usuário tem permissão para criar posts
if ($nivel_usuario != 1) {
    // Se não for aluno (nível 1), redirecionar para outra página
    header("Location: index.php");
    exit();
}

// Buscar postagens pendentes do banco de dados
$query_posts = "SELECT * FROM posts_pendentes ORDER BY data_envio DESC";
$result_posts = $conn->query($query_posts);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts Pendentes</title>
    <link rel="stylesheet" href="style.css">
</head>
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

/* Botão de criação de post */
.create-post-btn {
    display: flex;
    justify-content: flex-end;
    margin-top: 30px;
}

.create-post-btn button {
    width: 60px;
    height: 60px;
    background-color: #28a745;
    color: white;
    font-size: 36px;
    border-radius: 50%;
    border: none;
    cursor: pointer;
    display: flex;
    justify-content: center;
    align-items: center;
}

.create-post-btn button:hover {
    background-color: #218838;
}

    </style>
<body>
    <header>
        <div class="LogoDiv">
            <img class="LogoEtec" src="logo.png" alt="Logo Etec">
        </div>
        <div class="nav-container">
            <div class="nav-links">
                <a href="index.php">Início</a>
                <a href="Posts.php">Posts</a>
                <a href="perfil.php">Perfil</a>
            </div>
        </div>
        <div class="profile-icon">
            <!-- Icone de perfil -->
        </div>
    </header>

    <div class="container">
        <h2>Posts Pendentes</h2>
        
        <!-- Botão para Criar Post -->
        <?php if ($nivel_usuario == 1): ?>
        <div class="create-post-btn">
            <a href="criar_post.php">
                <button>+</button>
            </a>
        </div>
        <?php endif; ?>

        <!-- Exibir as postagens pendentes -->
        <?php if ($result_posts->num_rows > 0): ?>
            <?php while ($post = $result_posts->fetch_assoc()): ?>
                <div class="post">
                    <h3><?php echo $post['titulo']; ?></h3>
                    <p><?php echo $post['descricao']; ?></p>
                    <p><strong>Enviado por:</strong> <?php echo $post['id_usuario']; ?></p>
                    <p><strong>Status:</strong> <?php echo $post['status']; ?></p>
                    <div class="post-actions">
                        <!-- Ações disponíveis dependendo do status do post -->
                        <?php if ($nivel_usuario == 2): ?>
                            <a href="validar_post.php?id=<?php echo $post['id']; ?>">Aprovar</a>
                            <a href="recusar_post.php?id=<?php echo $post['id']; ?>">Negar</a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Não há postagens pendentes.</p>
        <?php endif; ?>
    </div>

    <footer>
        <p>&copy; 2025 - Todos os direitos reservados.</p>
    </footer>
</body>
</html>