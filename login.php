<?php
session_start();
include('conexao.php'); 

if (empty($_POST['email']) || empty($_POST['senha'])) {
    header('Location: index.php');
    exit();
}

$email = $_POST['email'];
$senha_digitada = $_POST['senha'];

$tipo_escolhido = $_SESSION['tipoLogin'] ?? null; 

$stmt = $conexao->prepare("SELECT id_usuario_pk, email, senha, tipo_usuario FROM usuario WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($user = $result->fetch_assoc()) {

    $senha_banco = $user['senha'];
    $login_ok = false;

    // 🟢 Caso 1: senha nova (password_hash)
    if (password_verify($senha_digitada, $senha_banco)) {
        $login_ok = true;
    }

    // 🟡 Caso 2: senha antiga (MD5)
    else if (md5($senha_digitada) === $senha_banco) {
        $login_ok = true;

        // 🔄 Atualiza automaticamente para password_hash
        $nova_hash = password_hash($senha_digitada, PASSWORD_DEFAULT);
        $update = $conexao->prepare("UPDATE usuario SET senha = ? WHERE id_usuario_pk = ?");
        $update->bind_param("si", $nova_hash, $user['id_usuario_pk']);
        $update->execute();
    }

    if ($login_ok) {

        if ($user['tipo_usuario'] == $tipo_escolhido) {
            $_SESSION['email'] = $user['email'];
            $_SESSION['id_usuario'] = $user['id_usuario_pk'];
            $_SESSION['tipoLogin'] = $user['tipo_usuario'];

            if ($user['tipo_usuario'] == 0) header('Location: admin.php');
            else if ($user['tipo_usuario'] == 1) header('Location: painel_coordenador.php');
            else header('Location: painel_secretario.php');

            exit();
        }
    }
}

$_SESSION['nao_autenticado'] = true;
header('Location: index.php');
exit();
?>