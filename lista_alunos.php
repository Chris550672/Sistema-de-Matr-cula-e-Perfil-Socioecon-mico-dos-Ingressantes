<?php
session_start();
include('conexao.php');

if(!isset($_SESSION['email'])){
    header('Location: index.php');
    exit();
}

$tipo = $_SESSION['tipoLogin'];

$busca = "";

if(isset($_GET['q'])){
    $busca = mysqli_real_escape_string($conexao, $_GET['q']);
    $sql = "SELECT * FROM aluno WHERE nome LIKE '%$busca%' ORDER BY id_aluno_pk ASC";
} else {
    $sql = "SELECT * FROM aluno ORDER BY id_aluno_pk ASC";
}

$result = mysqli_query($conexao, $sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Lista de Alunos</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<?php include('navbar.php'); ?>

<div class="container my-4">

    <div class="card shadow p-4">

        <h2 class="text-center mb-4">Lista de Alunos</h2>

        <!-- busca -->
        <form method="GET" class="input-group mb-4">
            <input type="text" name="q" class="form-control"
                   placeholder="Pesquisar aluno pelo nome..."
                   value="<?php echo htmlspecialchars($busca); ?>">

            <button class="btn btn-primary">Buscar</button>
        </form>

        <!-- tabela -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped shadow-sm">

                <thead class="table-dark text-center">
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Sexo</th>
                        <th>Telefone</th>
                        <th>Ações</th>
                    </tr>
                </thead>

                <tbody class="text-center">

                <?php if(mysqli_num_rows($result) > 0): ?>

                    <?php while($aluno = mysqli_fetch_assoc($result)): ?>

                    <tr>
                        <td><?php echo $aluno['id_aluno_pk']; ?></td>
                        <td><?php echo htmlspecialchars($aluno['nome']); ?></td>
                        <td><?php echo $aluno['sexo']; ?></td>
                        <td><?php echo $aluno['telefone']; ?></td>

                        <td>
                            <!-- perfil -->
                            <a href="perfil_aluno.php?id=<?php echo $aluno['id_aluno_pk']; ?>" 
                               class="btn btn-sm btn-info">
                               Perfil
                            </a>

                            <?php if($tipo == 2): ?>
                                <!-- editar (so secretario) -->
                                <a href="editar_aluno.php?id=<?php echo $aluno['id_aluno_pk']; ?>" 
                                   class="btn btn-sm btn-warning">
                                   Editar
                                </a>

                                <!-- excluir (so secretario) -->
                                <a href="excluir_aluno.php?id=<?php echo $aluno['id_aluno_pk']; ?>" 
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('Deseja realmente excluir?')">
                                   Excluir
                                </a>
                            <?php endif; ?>
                        </td>

                    </tr>

                    <?php endwhile; ?>

                <?php else: ?>

                    <tr>
                        <td colspan="5" class="text-danger">
                            Nenhum aluno encontrado!
                        </td>
                    </tr>

                <?php endif; ?>

                </tbody>
            </table>
        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>