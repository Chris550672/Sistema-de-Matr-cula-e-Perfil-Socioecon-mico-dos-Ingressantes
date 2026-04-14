<?php
session_start();
include('conexao.php');


$busca = "";
$result = null;

if(isset($_GET['q']) && !empty($_GET['q'])){
    $busca = $_GET['q'];
    $param = "%$busca%"; 
    
    $stmt = $conexao->prepare("SELECT * FROM usuario WHERE nome LIKE ? ORDER BY id_usuario_pk ASC");
    $stmt->bind_param("s", $param); // "s" de string
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conexao->query("SELECT * FROM usuario ORDER BY id_usuario_pk ASC");
}

function traduzirTipoUsuario($tipo){
    if($tipo == 0) return "Admin";
    if($tipo == 1) return "Coordenador";
    return "Secretário";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Painel Admin - <?php echo SISTEMA_NOME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>

<body class="bg-light">

<?php include('navbar.php'); ?>

<div class="container my-4">
    <div class="text-center mb-4">
        <h1 class="fw-bold text-success"><?php echo NOME_ESCOLA; ?></h1>
        <p class="text-muted">Gestão de Usuários do <?php echo SISTEMA_NOME; ?></p>
    </div>

    <div class="card shadow border-0 p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h4 mb-0">Lista de Usuários</h2>
            <a href="form_usuario.php" class="btn btn-success">
                <i class="bi bi-person-plus-fill"></i> Novo Usuário
            </a>
        </div>

        <form method="GET" action="admin.php" class="mb-4">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Buscar por nome..." value="<?php echo htmlspecialchars($busca); ?>">
                <button class="btn btn-primary" type="submit">
                    <i class="bi bi-search"></i> Pesquisar
                </button>
                <?php if(!empty($busca)): ?>
                    <a href="admin.php" class="btn btn-outline-secondary">Limpar</a>
                <?php endif; ?>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Nível de Acesso</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($user = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $user['id_usuario_pk']; ?></td>
                        <td class="fw-bold"><?php echo $user['nome']; ?></td>
                        <td><?php echo $user['email']; ?></td>
                        <td>
                            <span class="badge <?php echo ($user['tipo_usuario'] == 0) ? 'bg-danger' : 'bg-info'; ?>">
                                <?php echo traduzirTipoUsuario($user['tipo_usuario']); ?>
                            </span>
                        </td>
                        <td class="text-center">
                            <a href="editar_usuario.php?id=<?php echo $user['id_usuario_pk']; ?>" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <button class="btn btn-sm btn-danger" onclick="confirmarExclusao(<?php echo $user['id_usuario_pk']; ?>)">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function confirmarExclusao(id) {
    if(confirm('Tem certeza que deseja excluir este usuário?')) {
        window.location.href = 'excluir_usuario.php?id=' + id;
    }
}
</script>
</body>
</html>