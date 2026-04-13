<?php
session_start();
include('conexao.php');

if(!isset($_SESSION['email']) || $_SESSION['tipoLogin'] != 0){
    header('Location: index.php');
    exit();
}

if(!isset($_GET['id'])){
    die("ID não informado.");
}

$id = intval($_GET['id']);

$sql = "SELECT * FROM usuario WHERE id_usuario_pk = $id";
$result = mysqli_query($conexao, $sql);

if(mysqli_num_rows($result) == 0){
    die("Usuário não encontrado!");
}

$dados = mysqli_fetch_assoc($result);

function traduzirTipoUsuarioSelect($tipoAtual){
    $tipos = [
        0 => "Administrador",
        1 => "Coordenador",
        2 => "Secretário"
    ];

    foreach($tipos as $key => $value){
        $selected = ($tipoAtual == $key) ? "selected" : "";
        echo "<option value='$key' $selected>$value</option>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuário</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="card shadow">

        <div class="card-header bg-dark text-white">
            <h3 class="text-center">Editar Usuário</h3>
        </div>

        <div class="card-body">

            <form action="atualizar_usuario.php" method="POST">

                <input type="hidden" name="id" value="<?php echo $dados['id_usuario_pk']; ?>">

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label>Nome</label>
                        <input type="text" name="nome" class="form-control" required
                               value="<?php echo htmlspecialchars($dados['nome']); ?>">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required
                               value="<?php echo htmlspecialchars($dados['email']); ?>">
                    </div>

                </div>

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label>Nova Senha (opcional)</label>
                        <input type="password" name="senha" class="form-control"
                               placeholder="Deixe em branco para não alterar">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Tipo de Usuário</label>
                        <select name="tipo_usuario" class="form-control">
                            <?php traduzirTipoUsuarioSelect($dados['tipo_usuario']); ?>
                        </select>
                    </div>

                </div>

                <div class="text-center mt-4">
                    <button class="btn btn-success">Salvar Alterações</button>
                    <a href="admin.php" class="btn btn-secondary">Cancelar</a>
                </div>

            </form>

        </div>

    </div>

</div>

</body>
</html>