<?php
session_start();
include('conexao.php');

if(!isset($_SESSION['tipoLogin'])){
    header('Location: register.php');
    exit();
}

if (empty($_POST['email']) || empty($_POST['senha'])) {
    header('Location: index.php');
    exit();
}

$email = mysqli_real_escape_string($conexao, $_POST['email']);
$senha = mysqli_real_escape_string($conexao, $_POST['senha']);
$tipo  = $_SESSION['tipoLogin'];

$query = "SELECT id_usuario_pk, email FROM usuario 
WHERE email = '$email' 
AND senha = MD5('$senha') 
AND tipo_usuario = '$tipo'";

$result = mysqli_query($conexao, $query);

if (!$result) {
    die("Erro na consulta: " . mysqli_error($conexao));
}

if (mysqli_num_rows($result) == 1) {

    $_SESSION['email'] = $email;

    if($tipo == 0){
        header('Location: admin.php');
    } else if($tipo == 1){
        header('Location: painel_coordenador.php');
    } else {
        header('Location: painel_secretario.php');
    }

    exit();
}
else {
    $_SESSION['nao_autenticado'] = true;
    header('Location: index.php');
    exit();
}
?>