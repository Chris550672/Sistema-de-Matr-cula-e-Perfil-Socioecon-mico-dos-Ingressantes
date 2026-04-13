<?php
session_start();
include('conexao.php');

if(!isset($_SESSION['email']) || $_SESSION['tipoLogin'] != 1){
    header('Location: index.php');
    exit();
}

$email = $_SESSION['email'];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Painel Coordenador</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<?php include('navbar.php'); ?>

<div class="container mt-4">

<!--welcome-->
<div class="text-center mb-4">
    <h2>Olá, <?php echo $email; ?> </h2>
    <p class="text-muted">Bem-vindo ao painel do coordenador</p>
</div>

<!--effect card carrosel-->
<div id="carouselCards" class="carousel slide" data-bs-ride="carousel">

<div class="carousel-inner">

<!--card1-->
<div class="carousel-item active">
<div class="card shadow text-center p-4">

<h4>Dashboards</h4>
<p>
Acompanhe dados importantes do sistema através de gráficos interativos.  
Você poderá analisar informações como quantidade de alunos por curso, sexo e muito mais.
</p>

</div>
</div>

<!--card2-->
<div class="carousel-item">
<div class="card shadow text-center p-4">

<h4>Lista de Alunos</h4>
<p>
Visualize todos os alunos cadastrados no sistema.  
Acesse perfis completos com informações detalhadas de cada estudante.
</p>

</div>
</div>

<!--card3-->
<div class="carousel-item">
<div class="card shadow text-center p-4">

<h4>Perfis e Relatórios</h4>
<p>
Consulte dados completos dos alunos e exporte informações em PDF  
para análise ou documentação.
</p>

</div>
</div>

</div>

<!--controles-->
<button class="carousel-control-prev" type="button" data-bs-target="#carouselCards" data-bs-slide="prev">
<span class="carousel-control-prev-icon"></span>
</button>

<button class="carousel-control-next" type="button" data-bs-target="#carouselCards" data-bs-slide="next">
<span class="carousel-control-next-icon"></span>
</button>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>