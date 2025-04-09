<?php
include_once("Conexao.php");
session_start();

// Verificar se o usuário tem permissão
if ($_SESSION['nivel'] != 2) {  
    header("Location: MenuPrincipal.php"); 
    exit();
}

// Verificar se um ID válido foi passado
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID de postagem inválido.");
}

$id_post = $_GET['id'];

// Buscar a postagem do banco de dados
$query = "SELECT * FROM postagens WHERE id = '$id_post'";
$result = mysqli_query($conexao, $query);

if (mysqli_num_rows($result) == 0) {
    die("Postagem não encontrada.");
}

$post = mysqli_fetch_assoc($result);

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = mysqli_real_escape_string($conexao, $_POST['titulo']);
    $descricao = mysqli_real_escape_string($conexao, $_POST['descricao']);
    $imagem = $post['imagem']; // Manter a imagem antiga por padrão

    // Se uma nova imagem for enviada
    if (!empty($_FILES['imagem']['name'])) {
        $extensao = strtolower(pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION));
        $extensoes_permitidas = ['jpg', 'jpeg', 'png', 'gif'];

        if (!in_array($extensao, $extensoes_permitidas)) {
            die("Erro: Apenas arquivos JPG, JPEG, PNG e GIF são permitidos.");
        }

        if ($_FILES['imagem']['size'] > 5 * 1024 * 1024) { // 5MB
            die("Erro: O arquivo é muito grande. O limite é 5MB.");
        }

        $novo_nome = uniqid() . '.' . $extensao;
        $upload_dir = "uploads/";

        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $upload_dir . $novo_nome)) {
            $imagem = $novo_nome; // Atualizar a imagem com o novo nome
        } else {
            die("Erro ao enviar a imagem.");
        }
    }

    // Atualizar os dados no banco
    $updateQuery = "UPDATE postagens SET titulo = '$titulo', descricao = '$descricao', imagem = '$imagem' WHERE id = '$id_post'";
    
    if (mysqli_query($conexao, $updateQuery)) {
        header("Location: MenuPrincipal.php");
        exit();
    } else {
        echo "Erro ao editar o post: " . mysqli_error($conexao);
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Postagem</title>
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

        .container {
            max-width: 800px;
            margin: 120px auto;
            padding: 20px;
            background-color: #002F5F;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        h2 {
            text-align: center;
        }

        label {
            font-size: 16px;
        }

        input[type="text"], input[type="file"], textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #003f73;
            color: white;
        }

        button {
            background-color: #0056b3;
            color: white;
            border: none;
            padding: 10px 20px;
            width: 100%;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
        }

        button:hover {
            background-color: #003d82;
        }

        .erro {
            color: red;
            margin-top: 10px;
            font-size: 14px;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Editar Postagem</h2>
    <form action="EditarPostagem.php?id=<?php echo $id_post; ?>" method="POST" enctype="multipart/form-data">
        <label for="titulo">Título:</label>
        <input type="text" id="titulo" name="titulo" value="<?php echo htmlspecialchars($post['titulo']); ?>" required>

        <label for="descricao">Descrição:</label>
        <textarea id="descricao" name="descricao" rows="4" required><?php echo htmlspecialchars($post['descricao']); ?></textarea>

        <label for="imagem">Nova Imagem:</label>
        <input type="file" id="imagem" name="imagem">
        
        <?php if (!empty($post['imagem'])): ?>
            <p>Imagem Atual:</p>
            <img src="uploads/<?php echo htmlspecialchars($post['imagem']); ?>" width="200">
        <?php endif; ?>

        <button type="submit">Salvar Alterações</button>
    </form>
</div>

</body>
</html>