<?php
session_start();
include('conexao.php');

if(!isset($_SESSION['email']) || $_SESSION['tipoLogin'] != 0){
    header('Location: index.php');
    exit();
}

$id = $_GET['id'];

// evita excluir o admin
$sql_check = "SELECT tipo_usuario FROM usuario WHERE id_usuario_pk = '$id'";
$result = mysqli_query($conexao, $sql_check);
$user = mysqli_fetch_assoc($result);

if($user['tipo_usuario'] == 0){
    echo "Não pode excluir o administrador!";
    exit();
}

$sql = "DELETE FROM usuario WHERE id_usuario_pk = '$id'";

if(mysqli_query($conexao, $sql)){
    header('Location: admin.php');
} else {
    echo "Erro: " . mysqli_error($conexao);
}
?>