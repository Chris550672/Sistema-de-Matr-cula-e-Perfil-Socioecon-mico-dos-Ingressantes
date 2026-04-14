<?php
session_start();
include('conexao.php');

if(!isset($_SESSION['email']) || $_SESSION['tipoLogin'] != 2){
    header('Location: index.php');
    exit();
}

if(isset($_GET['id'])){
    $id = intval($_GET['id']);

    mysqli_query($conexao, "DELETE FROM saude WHERE id_aluno_fk = $id");
    mysqli_query($conexao, "DELETE FROM socioeconomico WHERE id_aluno_fk = $id");
    
    mysqli_query($conexao, "DELETE FROM matricula WHERE id_aluno_fk = $id");

    $sql_aluno = "DELETE FROM aluno WHERE id_aluno_pk = $id";
    
    if(mysqli_query($conexao, $sql_aluno)){
        header('Location: lista_alunos.php');
        exit();
    } else {
        echo "Erro ao excluir: " . mysqli_error($conexao);
    }
} else {
    header('Location: lista_alunos.php');
}
?>