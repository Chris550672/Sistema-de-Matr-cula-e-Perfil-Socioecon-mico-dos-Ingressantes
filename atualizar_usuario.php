<?php
session_start();
include('conexao.php');

if(!isset($_SESSION['email']) || $_SESSION['tipoLogin'] != 0){
    header('Location: index.php');
    exit();
}

$id    = $_POST['id'];
$nome  = mysqli_real_escape_string($conexao, trim($_POST['nome']));
$email = mysqli_real_escape_string($conexao, trim($_POST['email']));
$senha = trim($_POST['senha']);
$tipo  = mysqli_real_escape_string($conexao, $_POST['tipo_usuario']);

if(!empty($senha)){
    $senha = mysqli_real_escape_string($conexao, $senha);
    $sql = "UPDATE usuario 
            SET nome='$nome', email='$email', senha=MD5('$senha'), tipo_usuario='$tipo'
            WHERE id_usuario_pk='$id'";
} else {
    $sql = "UPDATE usuario 
            SET nome='$nome', email='$email', tipo_usuario='$tipo'
            WHERE id_usuario_pk='$id'";
}

if(mysqli_query($conexao, $sql)){
    header('Location: admin.php');
    exit();
} else {
    echo "Erro: " . mysqli_error($conexao);
}