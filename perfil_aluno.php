<?php
session_start();
include('conexao.php');

if(!isset($_SESSION['email'])){
    header('Location: index.php');
    exit();
}

if(!isset($_GET['id'])){
    header('Location: lista_alunos.php');
    exit();
}

$id = intval($_GET['id']);

//busca dados

$sql = "
SELECT 
    a.*, 
    s.*, 
    se.*
FROM aluno a
LEFT JOIN saude s ON s.id_aluno_fk = a.id_aluno_pk
LEFT JOIN socioeconomico se ON se.id_aluno_fk = a.id_aluno_pk
WHERE a.id_aluno_pk = '$id'
";

$result = mysqli_query($conexao, $sql);

if(mysqli_num_rows($result) == 0){
    echo "Aluno não encontrado!";
    exit();
}

$aluno = mysqli_fetch_assoc($result);

//foto (com padrão)
$foto = !empty($aluno['foto']) ? "uploads/" . $aluno['foto'] : "uploads/default.png";
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Perfil do Aluno</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<?php include('navbar.php'); ?>

<div class="container mt-4">

<!-- topo com foto -->
<div class="card mb-4 shadow">
<div class="card-body d-flex align-items-center">

<img src="<?php echo $foto; ?>" 
     class="rounded-circle me-4"
     style="width:120px; height:120px; object-fit:cover; border:3px solid #333;">

<div>
    <h3 class="mb-1"><?php echo $aluno['nome'] ?? '-'; ?></h3>
    <p class="mb-0 text-muted">CPF: <?php echo $aluno['cpf'] ?? '-'; ?></p>
</div>

</div>
</div>

<!-- upload de foto -->
<?php if($_SESSION['tipoLogin'] == 2): ?>
<div class="card mb-4">
<div class="card-body">

<form action="upload_foto.php" method="POST" enctype="multipart/form-data">

<input type="hidden" name="id" value="<?php echo $id; ?>">

<div class="mb-2">
<input type="file" name="foto" class="form-control" required>
</div>

<button class="btn btn-primary btn-sm">Atualizar Foto</button>

</form>

</div>
</div>
<?php endif; ?>

<!-- dados do aluno -->
<div class="card mb-4 shadow">
<div class="card-header bg-dark text-white">
Dados do Aluno
</div>

<div class="card-body">

<p><strong>Nome:</strong> <?php echo $aluno['nome'] ?? '-'; ?></p>
<p><strong>Data de nascimento:</strong> <?php echo $aluno['data_nasc'] ?? '-'; ?></p>
<p><strong>Sexo:</strong> <?php echo $aluno['sexo'] ?? '-'; ?></p>
<p><strong>CPF:</strong> <?php echo $aluno['cpf'] ?? '-'; ?></p>
<p><strong>RG:</strong> <?php echo $aluno['rg'] ?? '-'; ?></p>
<p><strong>Endereço:</strong> <?php echo $aluno['endereco'] ?? '-'; ?></p>
<p><strong>Telefone:</strong> <?php echo $aluno['telefone'] ?? '-'; ?></p>
<p><strong>Escola de origem:</strong> <?php echo $aluno['escola_origem'] ?? '-'; ?></p>

</div>
</div>

<!-- saude -->
<div class="card mb-4 shadow">
<div class="card-header bg-primary text-white">
Saúde
</div>

<div class="card-body">

<p><strong>Possui deficiência:</strong> <?php echo $aluno['possui_deficiencia'] ? 'Sim' : 'Não'; ?></p>
<p><strong>Tipo de deficiência:</strong> <?php echo $aluno['tipo_deficiencia'] ?? '-'; ?></p>

<p><strong>Possui alergia:</strong> <?php echo $aluno['possui_alergia'] ? 'Sim' : 'Não'; ?></p>
<p><strong>Tipo de alergia:</strong> <?php echo $aluno['tipo_alergia'] ?? '-'; ?></p>

<p><strong>Usa medicação:</strong> <?php echo $aluno['uso_medicacao'] ? 'Sim' : 'Não'; ?></p>
<p><strong>Tipo de medicação:</strong> <?php echo $aluno['tipo_medicacao'] ?? '-'; ?></p>

<p><strong>Restrição alimentar:</strong> <?php echo $aluno['restricao_alimentar'] ?? '-'; ?></p>

</div>
</div>

<!-- socioeconomico -->
<div class="card mb-4 shadow">
<div class="card-header bg-warning">
Socioeconômico
</div>

<div class="card-body">

<p><strong>Renda familiar:</strong> <?php echo $aluno['renda_familiar'] ?? '-'; ?></p>
<p><strong>Número de moradores:</strong> <?php echo $aluno['numero_moradores'] ?? '-'; ?></p>
<p><strong>Tipo de moradia:</strong> <?php echo $aluno['tipo_moradia'] ?? '-'; ?></p>

<p><strong>Possui internet:</strong> <?php echo $aluno['possui_internet'] ? 'Sim' : 'Não'; ?></p>
<p><strong>Recebe programa social:</strong> <?php echo $aluno['recebe_ps'] ? 'Sim' : 'Não'; ?></p>

</div>
</div>

<!-- botoes -->
<a href="lista_alunos.php" class="btn btn-secondary">Voltar</a>

<?php if($_SESSION['tipoLogin'] == 2): ?>
<a href="editar_aluno.php?id=<?php echo $id; ?>" class="btn btn-warning">
Editar
</a>
<a href="gerar_pdf_aluno.php?id=<?php echo $id; ?>" class="btn btn-danger">
Exportar PDF
</a>
<?php endif; ?>

</div>

</body>
</html>