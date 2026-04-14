<?php
session_start();
include('conexao.php');

if(!isset($_SESSION['email']) || $_SESSION['tipoLogin'] != 0){
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Painel Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<?php include('navbar.php'); ?>

<div class="container my-4">

    <div class="card shadow p-4">

        <h2 class="text-center mb-4">Lista de Usuários</h2>

        <!-- formulario cadastro -->
        <h5>Cadastrar Usuário</h5>

        <form action="cadastrar_usuario.php" method="POST" class="mb-4">

            <div class="row">
                <div class="col-md-6">
                    <input class="form-control mb-2" type="text" name="nome" placeholder="Nome" required>
                </div>

                <div class="col-md-6">
                    <input class="form-control mb-2" type="email" name="email" placeholder="Email" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <input class="form-control mb-2" type="password" name="senha" placeholder="Senha" required>
                </div>

                <div class="col-md-6">
                    <select class="form-control mb-2" name="tipo_usuario" required>
                        <option value="">Tipo de usuário</option>
                        <option value="1">Coordenador</option>
                        <option value="2">Secretário</option>
                    </select>
                </div>
            </div>

            <button class="btn btn-success w-100">Cadastrar</button>

        </form>

        <hr>

        
        <a href="logout.php" class="btn btn-secondary w-100 mt-3">Sair</a>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow">
</html>