<?php
session_start();
include('conexao.php');

if (empty($_POST['email']) || empty($_POST['senha'])) {
    header('Location: index.php');
    exit();
}

$email = $_POST['email'];
<<<<<<< HEAD
$senha = trim($_POST['senha']); // evita bug de espaço
=======
$senha_digitada = $_POST['senha'];
$tipo_escolhido = $_POST['tipo_usuario'] ?? $_SESSION['tipoLogin']; 
>>>>>>> 80f8d71fe0b797138576e9c6dc3021db868e7f87

// 🔒 usa prepared statement (segurança)
$stmt = $conexao->prepare("SELECT id_usuario_pk, email, senha, tipo_usuario FROM usuario WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($user = $result->fetch_assoc()) {
<<<<<<< HEAD

    if (password_verify($senha, $user['senha'])) {

        // ✅ cria sessão
        $_SESSION['email'] = $user['email'];
        $_SESSION['id_usuario'] = $user['id_usuario_pk'];
        $_SESSION['tipoLogin'] = $user['tipo_usuario'];

        // 🔀 redireciona baseado no tipo
        if ($user['tipo_usuario'] == 0) {
            header('Location: admin.php');
        } else if ($user['tipo_usuario'] == 1) {
            header('Location: painel_coordenador.php');
        } else {
            header('Location: painel_secretario.php');
        }

        exit();

    } else {
        // ❌ senha errada
        $_SESSION['nao_autenticado'] = true;
        header('Location: index.php');
        exit();
    }

} else {
    // ❌ usuário não existe
    $_SESSION['nao_autenticado'] = true;
    header('Location: index.php');
    exit();
}
?>
=======
    
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
>>>>>>> 80f8d71fe0b797138576e9c6dc3021db868e7f87
