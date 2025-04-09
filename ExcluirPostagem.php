<?php
include_once('Conexao.php');
session_start();

if ($_SESSION['nivel'] != 2) {  
    header("Location: MenuPrincipal.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Verifica se a postagem existe
    $checkQuery = "SELECT id FROM postagens WHERE id = ?";
    $stmt = mysqli_prepare($conexao, $checkQuery);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        // Apaga a postagem
        $deleteQuery = "DELETE FROM postagens WHERE id = ?";
        $stmt = mysqli_prepare($conexao, $deleteQuery);
        mysqli_stmt_bind_param($stmt, "i", $id);
        if (mysqli_stmt_execute($stmt)) {
            header("Location: MenuPrincipal.php?msg=Postagem excluída com sucesso");
            exit();
        } else {
            echo "Erro ao excluir postagem.";
        }
    } else {
        echo "Postagem não encontrada.";
    }
}
?>