<?php
session_start();
include('conexao.php');

if(!isset($_SESSION['email']) || $_SESSION['tipoLogin'] != 2){
    header('Location: index.php');
    exit();
}

if(!isset($_GET['id'])){
    header('Location: lista_alunos.php');
    exit();
}

$id = $_GET['id'];

// buscar dados
$sql = "
SELECT a.*, s.*, se.*
FROM aluno a
LEFT JOIN saude s ON s.id_aluno_fk = a.id_aluno_pk
LEFT JOIN socioeconomico se ON se.id_aluno_fk = a.id_aluno_pk
WHERE a.id_aluno_pk = '$id'
";

$result = mysqli_query($conexao, $sql);
$aluno = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Editar Aluno</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<?php include('navbar.php'); ?>

<div class="container mt-4">

<h2 class="mb-4">Editar Aluno</h2>

<form action="atualizar_aluno.php" method="POST">

<input type="hidden" name="id" value="<?php echo $id; ?>">

<!-- dados aluno -->
<div class="card mb-4">
<div class="card-header">Dados do Aluno</div>
<div class="card-body">

<input class="form-control mb-2" name="nome" value="<?php echo $aluno['nome']; ?>" required>
<input class="form-control mb-2" type="date" name="data_nasc" value="<?php echo $aluno['data_nasc']; ?>" required>

<select class="form-control mb-2" name="sexo">
    <option value="Masculino" <?php if($aluno['sexo']=='Masculino') echo 'selected'; ?>>Masculino</option>
    <option value="Feminino" <?php if($aluno['sexo']=='Feminino') echo 'selected'; ?>>Feminino</option>
</select>

<input class="form-control mb-2" name="cpf" value="<?php echo $aluno['cpf']; ?>">
<input class="form-control mb-2" name="rg" value="<?php echo $aluno['rg']; ?>">
<input class="form-control mb-2" name="endereco" value="<?php echo $aluno['endereco']; ?>">
<input class="form-control mb-2" name="telefone" value="<?php echo $aluno['telefone']; ?>">
<input class="form-control mb-2" name="escola_origem" value="<?php echo $aluno['escola_origem']; ?>">

</div>
</div>

<!-- saud -->
<div class="card mb-4">
<div class="card-header">Saúde</div>
<div class="card-body">

<select class="form-control mb-2" name="possui_deficiencia">
    <option value="0" <?php if(!$aluno['possui_deficiencia']) echo 'selected'; ?>>Não</option>
    <option value="1" <?php if($aluno['possui_deficiencia']) echo 'selected'; ?>>Sim</option>
</select>

<input class="form-control mb-2" name="tipo_deficiencia" value="<?php echo $aluno['tipo_deficiencia']; ?>">

<select class="form-control mb-2" name="possui_alergia">
    <option value="0" <?php if(!$aluno['possui_alergia']) echo 'selected'; ?>>Não</option>
    <option value="1" <?php if($aluno['possui_alergia']) echo 'selected'; ?>>Sim</option>
</select>

<input class="form-control mb-2" name="tipo_alergia" value="<?php echo $aluno['tipo_alergia']; ?>">

<select class="form-control mb-2" name="uso_medicacao">
    <option value="0" <?php if(!$aluno['uso_medicacao']) echo 'selected'; ?>>Não</option>
    <option value="1" <?php if($aluno['uso_medicacao']) echo 'selected'; ?>>Sim</option>
</select>

<input class="form-control mb-2" name="tipo_medicacao" value="<?php echo $aluno['tipo_medicacao']; ?>">

<input class="form-control mb-2" name="restricao_alimentar" value="<?php echo $aluno['restricao_alimentar']; ?>">

</div>
</div>

<!-- socio -->
<div class="card mb-4">
<div class="card-header">Socioeconômico</div>
<div class="card-body">

<input class="form-control mb-2" name="renda_familiar" value="<?php echo $aluno['renda_familiar']; ?>">
<input class="form-control mb-2" name="numero_moradores" value="<?php echo $aluno['numero_moradores']; ?>">
<input class="form-control mb-2" name="tipo_moradia" value="<?php echo $aluno['tipo_moradia']; ?>">

<select class="form-control mb-2" name="possui_internet">
    <option value="0" <?php if(!$aluno['possui_internet']) echo 'selected'; ?>>Não</option>
    <option value="1" <?php if($aluno['possui_internet']) echo 'selected'; ?>>Sim</option>
</select>

<select class="form-control mb-2" name="recebe_ps">
    <option value="0" <?php if(!$aluno['recebe_ps']) echo 'selected'; ?>>Não</option>
    <option value="1" <?php if($aluno['recebe_ps']) echo 'selected'; ?>>Sim</option>
</select>

</div>
</div>

<button class="btn btn-success">Salvar Alterações</button>

</form>

</div>
</body>
</html>