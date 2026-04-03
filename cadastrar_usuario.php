<?php
session_start();
include('conexao.php');

if(!isset($_SESSION['email']) || $_SESSION['tipoLogin'] != 0){
    header('Location: index.php');
    exit();
}

$nome  = mysqli_real_escape_string($conexao, trim($_POST['nome']));
$email = mysqli_real_escape_string($conexao, trim($_POST['email']));
$senha = mysqli_real_escape_string($conexao, trim($_POST['senha']));
$tipo  = mysqli_real_escape_string($conexao, $_POST['tipo_usuario']);

// verifica se o usuario ja existe
$sql = "SELECT COUNT(*) AS total FROM usuario WHERE email = '$email'";
$result = mysqli_query($conexao, $sql);
$row = mysqli_fetch_assoc($result);

if($row['total'] > 0){
    echo "Usuário já existe!";
    exit();
}

// insere no banco
$sql = "INSERT INTO usuario (nome, email, senha, tipo_usuario)
VALUES ('$nome', '$email', MD5('$senha'), '$tipo')";

if(mysqli_query($conexao, $sql)){
    header('Location: admin.php');
    exit();
} else {
    echo "Erro: " . mysqli_error($conexao);
}