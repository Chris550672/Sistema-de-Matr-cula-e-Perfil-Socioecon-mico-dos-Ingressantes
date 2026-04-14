<?php
session_start();
include('conexao.php');

if(!isset($_SESSION['email']) || $_SESSION['tipoLogin'] != 0){
    header('Location: index.php');
    exit();
}

$nome = trim($_POST['nome']);
$email = trim($_POST['email']);
$senha_pura = $_POST['senha'];
$tipo = $_POST['tipo_usuario'];

$senha_hash = password_hash($senha_pura, PASSWORD_DEFAULT);

$sql = "INSERT INTO usuario (nome, email, senha, tipo_usuario) VALUES (?, ?, ?, ?)";
$stmt = $conexao->prepare($sql);

// "sssi" significa string, string, string e integer
$stmt->bind_param("sssi", $nome, $email, $senha_hash, $tipo);

if($stmt->execute()){
    
    header('Location: admin.php?sucesso=1');
} else {
    
    echo "Erro ao cadastrar: " . $conexao->error;
}

$stmt->close();
$conexao->close();
?>