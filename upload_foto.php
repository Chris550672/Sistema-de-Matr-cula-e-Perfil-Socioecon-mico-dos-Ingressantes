<?php
session_start();
include('conexao.php');

if(!isset($_SESSION['email'])){
    header('Location: index.php');
    exit();
}

if(!isset($_POST['id']) || !isset($_FILES['foto'])){
    die("Dados inválidos");
}

$id = intval($_POST['id']);

$arquivo = $_FILES['foto'];

$extensao = strtolower(pathinfo($arquivo['name'], PATHINFO_EXTENSION));

if($extensao != 'jpg' && $extensao != 'jpeg' && $extensao != 'png'){
    die("Formato inválido");
}

$nomeArquivo = uniqid() . '.' . $extensao;

if(!move_uploaded_file($arquivo['tmp_name'], "uploads/" . $nomeArquivo)){
    die("Erro ao enviar imagem");
}

$sql = "UPDATE aluno SET foto='$nomeArquivo' WHERE id_aluno_pk='$id'";
mysqli_query($conexao, $sql);

header("Location: perfil_aluno.php?id=$id");
exit();
?>