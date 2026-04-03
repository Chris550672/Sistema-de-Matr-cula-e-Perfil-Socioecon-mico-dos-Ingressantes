<?php
session_start();
include('conexao.php');

if(!isset($_SESSION['email']) || $_SESSION['tipoLogin'] != 2){
    header('Location: index.php');
    exit();
}

// total de alunos
$sql_total = "SELECT COUNT(*) as total FROM aluno";
$result_total = mysqli_query($conexao, $sql_total);
$total_alunos = mysqli_fetch_assoc($result_total)['total'];

// total de matriculas
$sql_mat = "SELECT COUNT(*) as total FROM matricula";
$result_mat = mysqli_query($conexao, $sql_mat);
$total_matriculas = mysqli_fetch_assoc($result_mat)['total'];

// ultima matricula
$sql_ultima = "
    SELECT aluno.nome, matricula.data_mat
    FROM matricula
    INNER JOIN aluno ON aluno.id_aluno_pk = matricula.id_aluno_fk
    ORDER BY matricula.id_mat_pk DESC
    LIMIT 1
";

$result_ultima = mysqli_query($conexao, $sql_ultima);

$ultima_matricula = null;
if(mysqli_num_rows($result_ultima) > 0){
    $ultima_matricula = mysqli_fetch_assoc($result_ultima);
}
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

<div class="container mt-4">

    <h2 class="text-center mb-4">Painel do Secretário</h2>

    <!-- cards -->
    <div class="row mb-4">

        <div class="col-md-4">
            <div class="card text-center shadow">
                <div class="card-body">
                    <h5>Total de Alunos</h5>
                    <h2><?php echo $total_alunos; ?></h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-center shadow">
                <div class="card-body">
                    <h5>Total de Matrículas</h5>
                    <h2><?php echo $total_matriculas; ?></h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-center shadow">
                <div class="card-body">
                    <h5>Última Matrícula</h5>

                    <?php if($ultima_matricula): ?>
                        <p class="mb-1">
                            <strong><?php echo htmlspecialchars($ultima_matricula['nome']); ?></strong>
                        </p>
                        <small class="text-muted">
                            <?php echo $ultima_matricula['data_mat']; ?>
                        </small>
                    <?php else: ?>
                        <p class="text-muted">Nenhuma matrícula ainda</p>
                    <?php endif; ?>

                </div>
            </div>
        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>