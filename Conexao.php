<?php 

    $dbHost = 'localhost';
    $dbUsername = 'root';
    $dbPassword = '';
    $dbName = 'TCC';

    $conexao = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

    /*
       if($conexao->connect_errno)
    { 
          echo "Deu alguma coisa errada";
        }
       else
    {
          echo "Conexão bem sucedida";
        }
    */
    
?>