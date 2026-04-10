<?php
session_start();
include('conexao.php');

if(!isset($_SESSION['email'])){
    header('Location: index.php');
    exit();
}

if(!isset($_POST['id'])){
    header('Location: lista_alunos.php');
    exit();
}

$id = intval($_POST['id']);

// verifica arquivo
if(!isset($_FILES['foto']) || $_FILES['foto']['error'] != 0){
    header("Location: perfil_aluno.php?id=$id&erro=upload");
    exit();
}

$arquivo = $_FILES['foto'];

$extensao = strtolower(pathinfo($arquivo['name'], PATHINFO_EXTENSION));

// valida extensão
if(!in_array($extensao, ['jpg', 'jpeg', 'png'])){
    header("Location: perfil_aluno.php?id=$id&erro=formato");
    exit();
}

// cria pasta se não existir
if(!is_dir('uploads')){
    mkdir('uploads');
}

$nomeArquivo = uniqid() . '.' . $extensao;

if(!move_uploaded_file($arquivo['tmp_name'], "uploads/" . $nomeArquivo)){
    header("Location: perfil_aluno.php?id=$id&erro=salvar");
    exit();
}

// salva no banco
$sql = "UPDATE aluno SET foto='$nomeArquivo' WHERE id_aluno_pk='$id'";
mysqli_query($conexao, $sql);

header("Location: perfil_aluno.php?id=$id&sucesso=1");
exit();
