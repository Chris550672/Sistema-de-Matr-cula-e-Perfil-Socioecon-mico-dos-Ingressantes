<?php
session_start();
include('conexao.php');

if(!isset($_SESSION['email']) || $_SESSION['tipoLogin'] != 2){
    header('Location: index.php');
    exit();
}

//dados do aluno

$nome = mysqli_real_escape_string($conexao, $_POST['nome']);
$data_nasc = $_POST['data_nasc'];
$sexo = $_POST['sexo'];

//limpeza dos dados para envio p db
$cpf = preg_replace('/\D/', '', $_POST['cpf']);
$telefone = preg_replace('/\D/', '', $_POST['telefone']);

$rg = $_POST['rg'];
$endereco = $_POST['endereco'];
$escola_origem = $_POST['escola_origem'];

//inserindo aluno
$sql_aluno = "INSERT INTO aluno 
(nome, data_nasc, sexo, cpf, rg, endereco, telefone, escola_origem)
VALUES 
('$nome', '$data_nasc', '$sexo', '$cpf', '$rg', '$endereco', '$telefone', '$escola_origem')";

if(!mysqli_query($conexao, $sql_aluno)){
    die("Erro ao cadastrar aluno: " . mysqli_error($conexao));
}

//pegando id do aluno
$id_aluno = mysqli_insert_id($conexao);

//dados saude

$possui_deficiencia = $_POST['possui_deficiencia'] ?? 0;
$tipo_deficiencia = $_POST['tipo_deficiencia'] ?? '';

$possui_alergia = $_POST['possui_alergia'] ?? 0;
$tipo_alergia = $_POST['tipo_alergia'] ?? '';

$uso_medicacao = $_POST['uso_medicacao'] ?? 0;
$tipo_medicacao = $_POST['tipo_medicacao'] ?? '';

$restricao_alimentar = $_POST['restricao_alimentar'] ?? '';

$sql_saude = "INSERT INTO saude
(possui_deficiencia, tipo_deficiencia, possui_alergia, tipo_alergia, uso_medicacao, tipo_medicacao, restricao_alimentar, id_aluno_fk)
VALUES
('$possui_deficiencia', '$tipo_deficiencia', '$possui_alergia', '$tipo_alergia', '$uso_medicacao', '$tipo_medicacao', '$restricao_alimentar', '$id_aluno')";

if(!mysqli_query($conexao, $sql_saude)){
    die("Erro na saúde: " . mysqli_error($conexao));
}

//dados socioeconomico

$renda_familiar = $_POST['renda_familiar'] ?? '';
$numero_moradores = $_POST['numero_moradores'] ?? '';
$tipo_moradia = $_POST['tipo_moradia'] ?? '';
$possui_internet = $_POST['possui_internet'] ?? 0;
$recebe_ps = $_POST['recebe_ps'] ?? 0;

$sql_socio = "INSERT INTO socioeconomico
(renda_familiar, numero_moradores, tipo_moradia, possui_internet, recebe_ps, id_aluno_fk)
VALUES
('$renda_familiar', '$numero_moradores', '$tipo_moradia', '$possui_internet', '$recebe_ps', '$id_aluno')";

if(!mysqli_query($conexao, $sql_socio)){
    die("Erro socioeconômico: " . mysqli_error($conexao));
}

//sucesso

header('Location: lista_alunos.php');
exit();
?>