<?php
session_start();
include('conexao.php');

if(!isset($_SESSION['email']) || $_SESSION['tipoLogin'] != 0){
    header('Location: index.php');
    exit();
}

$busca = "";

if(isset($_GET['q'])){
    $busca = mysqli_real_escape_string($conexao, $_GET['q']);
    $sql = "SELECT * FROM usuario WHERE nome LIKE '%$busca%' ORDER BY id_usuario_pk ASC";
} else {
    $sql = "SELECT * FROM usuario ORDER BY id_usuario_pk ASC";
}

$result = mysqli_query($conexao, $sql);

function traduzirTipoUsuario($tipo){
    if($tipo == 0) return "Admin";
    if($tipo == 1) return "Coordenador";
    return "Secretário";
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

        <!-- busca -->
        <form method="GET" class="input-group mb-4">
            <input type="text" name="q" class="form-control"
                   placeholder="Pesquisar usuário pelo nome..."
                   value="<?php echo htmlspecialchars($busca); ?>">

            <button class="btn btn-primary">Buscar</button>
        </form>

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

        <!-- tabela -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped shadow-sm">

                <thead class="table-dark text-center">
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Tipo</th>
                        <th>Ações</th>
                    </tr>
                </thead>

                <tbody class="text-center">

                <?php if(mysqli_num_rows($result) > 0): ?>

                    <?php while($user = mysqli_fetch_assoc($result)): ?>

                    <tr>
                        <td><?php echo $user['id_usuario_pk']; ?></td>
                        <td><?php echo htmlspecialchars($user['nome']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>

                        <td>
                            <span class="badge bg-secondary">
                                <?php echo traduzirTipoUsuario($user['tipo_usuario']); ?>
                            </span>
                        </td>

                        <td>
                            <a href="editar_usuario.php?id=<?php echo $user['id_usuario_pk']; ?>" 
                               class="btn btn-sm btn-primary">Editar</a>

                            <a href="excluir.php?id=<?php echo $user['id_usuario_pk']; ?>" 
                               class="btn btn-sm btn-danger"
                               onclick="return confirm('Deseja realmente excluir?')">
                               Excluir
                            </a>
                        </td>
                    </tr>

                    <?php endwhile; ?>

                <?php else: ?>

                    <tr>
                        <td colspan="5" class="text-danger text-center">
                            Nenhum usuário encontrado!
                        </td>
                    </tr>

                <?php endif; ?>

                </tbody>
            </table>
        </div>

        <a href="logout.php" class="btn btn-secondary w-100 mt-3">Sair</a>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow">
</html>
