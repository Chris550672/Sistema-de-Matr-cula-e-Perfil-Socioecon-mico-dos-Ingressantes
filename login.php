<?php
session_start();
include('conexao.php');

if (empty($_POST['email']) || empty($_POST['senha'])) {
    header('Location: index.php');
    exit();
}

$email = $_POST['email'];
$senha_digitada = $_POST['senha'];
$tipo_escolhido = $_POST['tipo_usuario'] ?? $_SESSION['tipoLogin']; 

$stmt = $conexao->prepare("SELECT id_usuario_pk, email, senha, tipo_usuario FROM usuario WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($user = $result->fetch_assoc()) {
    
    if (password_verify($senha_digitada, $user['senha'])) {
        
        if($user['tipo_usuario'] == $tipo_escolhido) {
            $_SESSION['email'] = $user['email'];
            $_SESSION['tipoLogin'] = $user['tipo_usuario'];

            if($user['tipo_usuario'] == 0) header('Location: admin.php');
            else if($user['tipo_usuario'] == 1) header('Location: painel_coordenador.php');
            else header('Location: painel_secretario.php');
            exit();
        } else {
            $_SESSION['erro_login'] = "Nível de acesso incorreto.";
        }
    } else {
        $_SESSION['erro_login'] = "Senha inválida.";
    }
} else {
    $_SESSION['erro_login'] = "Usuário não encontrado.";
}

$_SESSION['nao_autenticado'] = true;
header('Location: index.php');
exit();
