<?php
session_start();
include('conexao.php');

if (empty($_POST['nome']) || empty($_POST['email']) || empty($_POST['senha'])) {
    $_SESSION['mensagem'] = "Preencha todos os campos!";
    header('Location: telacadastro.php');
    exit();
}

$nome  = mysqli_real_escape_string($conexao, trim($_POST['nome']));
$email = mysqli_real_escape_string($conexao, trim($_POST['email']));
$senha = mysqli_real_escape_string($conexao, trim($_POST['senha']));

$tipo = 2; 

$sql = "SELECT COUNT(*) AS total FROM usuario WHERE email = '$email'";
$result = mysqli_query($conexao, $sql);
$row = mysqli_fetch_assoc($result);

if ($row['total'] > 0) {
    $_SESSION['mensagem'] = "E-mail já cadastrado!";
    header('Location: telacadastro.php');
    exit();
}

$sql = "INSERT INTO usuario (nome, email, senha, tipo_usuario) 
VALUES ('$nome', '$email', MD5('$senha'), '$tipo')";

if (mysqli_query($conexao, $sql)) {
    $_SESSION['mensagem'] = "Cadastro realizado com sucesso!";
    header('Location: index.php');
    exit();
} else {
    $_SESSION['mensagem'] = "Erro ao cadastrar: " . mysqli_error($conexao);
    header('Location: telacadastro.php');
    exit();
}
?>