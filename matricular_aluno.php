<?php
session_start();

if(!isset($_SESSION['email']) || $_SESSION['tipoLogin'] != 2){
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Matricular Aluno</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<script>
//mascara do cpf
function mascaraCPF(input){
    let v = input.value.replace(/\D/g, '').slice(0,11);
    v = v.replace(/(\d{3})(\d)/, "$1.$2");
    v = v.replace(/(\d{3})(\d)/, "$1.$2");
    v = v.replace(/(\d{3})(\d{1,2})$/, "$1-$2");
    input.value = v;
}

//mascara do telefone
function mascaraTel(input){
    let v = input.value.replace(/\D/g, '').slice(0,11);
    v = v.replace(/(\d{2})(\d)/, "($1) $2");
    v = v.replace(/(\d{5})(\d)/, "$1-$2");
    input.value = v;
}

//condiciojais
function toggleCampo(select, campoId){
    let campo = document.getElementById(campoId);
    campo.style.display = (select.value == "1") ? "block" : "none";
}
</script>

</head>

<body class="bg-light">

<?php include('navbar.php'); ?>

<div class="container my-4">

<h2 class="text-center mb-4">Matricular Aluno</h2>

<form action="salvar_aluno.php" method="POST">

<!-- dados do aluno -->
<div class="card shadow mb-4">
<div class="card-header bg-dark text-white">Dados do Aluno</div>

<div class="card-body">

<input class="form-control mb-2" name="nome" placeholder="Nome completo" required>

<div class="row">
<div class="col-md-6">
<input type="date" class="form-control mb-2" name="data_nasc" required>
</div>

<div class="col-md-6">
<select class="form-control mb-2" name="sexo" required>
<option value="">Sexo</option>
<option>Masculino</option>
<option>Feminino</option>
</select>
</div>
</div>

<div class="row">
<div class="col-md-6">
<input class="form-control mb-2" name="cpf" placeholder="CPF"
oninput="mascaraCPF(this)" required>
</div>

<div class="col-md-6">
<input class="form-control mb-2" name="rg" placeholder="RG" required>
</div>
</div>

<input class="form-control mb-2" name="endereco" placeholder="Endereço">

<input class="form-control mb-2" name="telefone" placeholder="Telefone"
oninput="mascaraTel(this)">

<input class="form-control mb-2" name="escola_origem" placeholder="Escola de origem">

</div>
</div>

<!-- saude -->
<div class="card shadow mb-4">
<div class="card-header bg-primary text-white">Saúde</div>

<div class="card-body">

<label>Possui deficiência?</label>
<select class="form-control mb-2" name="possui_deficiencia"
onchange="toggleCampo(this, 'deficienciaCampo')">
<option value="0">Não</option>
<option value="1">Sim</option>
</select>

<div id="deficienciaCampo" style="display:none;">
<input class="form-control mb-2" name="tipo_deficiencia" placeholder="Qual deficiência?">
</div>

<label>Possui alergia?</label>
<select class="form-control mb-2" name="possui_alergia"
onchange="toggleCampo(this, 'alergiaCampo')">
<option value="0">Não</option>
<option value="1">Sim</option>
</select>

<div id="alergiaCampo" style="display:none;">
<input class="form-control mb-2" name="tipo_alergia" placeholder="Qual alergia?">
</div>

<label>Usa medicação?</label>
<select class="form-control mb-2" name="uso_medicacao"
onchange="toggleCampo(this, 'medicacaoCampo')">
<option value="0">Não</option>
<option value="1">Sim</option>
</select>

<div id="medicacaoCampo" style="display:none;">
<input class="form-control mb-2" name="tipo_medicacao" placeholder="Qual medicação?">
</div>

<label>Possui restrição alimentar?</label>
<select class="form-control mb-2" onchange="toggleCampo(this, 'restricaoCampo')">
<option value="0">Não</option>
<option value="1">Sim</option>
</select>

<div id="restricaoCampo" style="display:none;">
<input class="form-control mb-2" name="restricao_alimentar" placeholder="Qual restrição?">
</div>

</div>
</div>

<!-- socioeconomico -->
<div class="card shadow mb-4">
<div class="card-header bg-warning">Socioeconômico</div>

<div class="card-body">

<select class="form-control mb-2" name="renda_familiar">
<option value="">Faixa de renda</option>
<option>Até R$ 1.000</option>
<option>R$ 1.001 a R$ 2.000</option>
<option>R$ 2.001 a R$ 5.000</option>
<option>Acima de R$ 5.000</option>
</select>

<input class="form-control mb-2" name="numero_moradores" placeholder="Número de moradores">

<select class="form-control mb-2" name="tipo_moradia">
<option value="">Tipo de moradia</option>
<option>Casa</option>
<option>Apartamento</option>
<option>Outro</option>
</select>

<label>Possui internet?</label>
<select class="form-control mb-2" name="possui_internet">
<option value="0">Não</option>
<option value="1">Sim</option>
</select>

<label>Recebe programa social?</label>
<select class="form-control mb-2" name="recebe_ps">
<option value="0">Não</option>
<option value="1">Sim</option>
</select>

</div>
</div>

<button class="btn btn-success w-100">Cadastrar Aluno</button>

</form>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>