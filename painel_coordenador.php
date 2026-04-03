<?php
session_start();

if(!isset($_SESSION['email']) || $_SESSION['tipoLogin'] != 1){
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Painel do Coordenador</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<?php include('navbar.php'); ?>

<div class="container mt-4">

    <h2 class="text-center">Painel do Coordenador</h2>

    <p class="text-center text-muted">
        Aqui ficarão dashboards e análises do sistema.
    </p>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>