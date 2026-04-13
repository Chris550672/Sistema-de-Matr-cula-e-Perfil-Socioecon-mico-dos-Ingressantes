<?php
session_start();
include('conexao.php');

if(!isset($_SESSION['email']) || $_SESSION['tipoLogin'] != 2){
    header('Location: index.php');
    exit();
}

$sql_total = "SELECT COUNT(*) as total FROM aluno";
$result_total = mysqli_query($conexao, $sql_total);
$total_alunos = mysqli_fetch_assoc($result_total)['total'];

$sql_ultima = "SELECT nome FROM aluno ORDER BY id_aluno_pk DESC LIMIT 1";
$result_ultima = mysqli_query($conexao, $sql_ultima);
$ultima_matricula = mysqli_num_rows($result_ultima) > 0 ? mysqli_fetch_assoc($result_ultima) : null;
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Painel do Secretário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<?php include('navbar.php'); ?>

<div class="container mt-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold text-success">Bem-vindo, Secretário</h2>
        <p class="text-muted">Resumo do sistema de matrículas.</p>
    </div>

    <div class="row justify-content-center mb-4">
        <div class="col-md-5">
            <div class="card shadow-sm border-success text-center h-100">
                <div class="card-body">
                    <h5 class="text-success fw-bold">Alunos Ativos</h5>
                    <h1 class="display-4 fw-bold"><?php echo $total_alunos; ?></h1>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card shadow-sm border-primary text-center h-100">
                <div class="card-body">
                    <h5 class="text-primary fw-bold">Último Cadastrado</h5>
                    <?php if($ultima_matricula): ?>
                        <h3 class="mt-3"><?php echo htmlspecialchars($ultima_matricula['nome']); ?></h3>
                    <?php else: ?>
                        <p class="text-muted mt-3">Nenhum aluno ainda</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-5 mb-3">
            <a href="lista_alunos.php" class="btn btn-outline-success btn-lg w-100 shadow-sm">📋 Gerenciar Alunos</a>
        </div>
        <div class="col-md-5 mb-3">
            <a href="matricular_aluno.php" class="btn btn-success btn-lg w-100 shadow-sm">➕ Nova Matrícula</a>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>