<?php
include_once('Conexao.php');
session_start();

if ($_SESSION['nivel'] != 2) {  
    header("Location: MenuPrincipal.php"); 
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = mysqli_real_escape_string($conexao, $_POST['titulo']);
    $descricao = mysqli_real_escape_string($conexao, $_POST['descricao']);
    
    $imagem = $_FILES['imagem']['name'];
    $imagem_temp = $_FILES['imagem']['tmp_name'];
    $upload_dir = 'uploads/';
    
    // Verificar se um arquivo foi enviado
    if (!empty($imagem)) {
        $extensao = strtolower(pathinfo($imagem, PATHINFO_EXTENSION));
        $extensoes_permitidas = ['jpg', 'jpeg', 'png', 'gif'];
        
        if (!in_array($extensao, $extensoes_permitidas)) {
            die("Erro: Apenas arquivos JPG, JPEG, PNG e GIF são permitidos.");
        }

        if ($_FILES['imagem']['size'] > 5 * 1024 * 1024) { // 5MB
            die("Erro: O arquivo é muito grande. O limite é 5MB.");
        }

        // Criar um nome único para a imagem
        $novo_nome = uniqid() . '.' . $extensao;
        
        if (move_uploaded_file($imagem_temp, $upload_dir . $novo_nome)) {
            $query = "INSERT INTO postagens (titulo, descricao, imagem) VALUES ('$titulo', '$descricao', '$novo_nome')";
            
            if (mysqli_query($conexao, $query)) {
                header("Location: MenuPrincipal.php");  
            } else {
                echo "Erro ao criar postagem: " . mysqli_error($conexao);
            }
        } else {
            echo "Erro ao enviar a imagem.";
        }
    } else {
        echo "Erro: Nenhuma imagem foi enviada.";
    }
}
?>