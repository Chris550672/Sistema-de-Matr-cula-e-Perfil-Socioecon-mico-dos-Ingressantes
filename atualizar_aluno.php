<?php
session_start();
include('conexao.php');

if(!isset($_SESSION['email']) || $_SESSION['tipoLogin'] != 2){
    header('Location: index.php');
    exit();
}

$id = intval($_POST['id']);

//dados do aluno
$nome = mysqli_real_escape_string($conexao, $_POST['nome']);
$data_nasc = $_POST['data_nasc'];
$sexo = $_POST['sexo'];

$cpf = preg_replace('/\D/', '', $_POST['cpf']);
$telefone = preg_replace('/\D/', '', $_POST['telefone']);

$rg = $_POST['rg'];
$endereco = $_POST['endereco'];
$escola_origem = $_POST['escola_origem'];

mysqli_query($conexao, "UPDATE aluno SET
nome='$nome',
data_nasc='$data_nasc',
sexo='$sexo',
cpf='$cpf',
rg='$rg',
endereco='$endereco',
telefone='$telefone',
escola_origem='$escola_origem'
WHERE id_aluno_pk='$id'");

//saude
$possui_deficiencia = $_POST['possui_deficiencia'];
$tipo_deficiencia = $possui_deficiencia ? $_POST['tipo_deficiencia'] : '';

$possui_alergia = $_POST['possui_alergia'];
$tipo_alergia = $possui_alergia ? $_POST['tipo_alergia'] : '';

$uso_medicacao = $_POST['uso_medicacao'];
$tipo_medicacao = $uso_medicacao ? $_POST['tipo_medicacao'] : '';

$restricao_alimentar = $_POST['restricao_alimentar'] ?? '';

$check = mysqli_query($conexao, "SELECT * FROM saude WHERE id_aluno_fk='$id'");

if(mysqli_num_rows($check)){
    mysqli_query($conexao, "UPDATE saude SET
    possui_deficiencia='$possui_deficiencia',
    tipo_deficiencia='$tipo_deficiencia',
    possui_alergia='$possui_alergia',
    tipo_alergia='$tipo_alergia',
    uso_medicacao='$uso_medicacao',
    tipo_medicacao='$tipo_medicacao',
    restricao_alimentar='$restricao_alimentar'
    WHERE id_aluno_fk='$id'");
}else{
    mysqli_query($conexao, "INSERT INTO saude
    (possui_deficiencia,tipo_deficiencia,possui_alergia,tipo_alergia,uso_medicacao,tipo_medicacao,restricao_alimentar,id_aluno_fk)
    VALUES
    ('$possui_deficiencia','$tipo_deficiencia','$possui_alergia','$tipo_alergia','$uso_medicacao','$tipo_medicacao','$restricao_alimentar','$id')");
}

//socio
$renda = $_POST['renda_familiar'];
$moradores = $_POST['numero_moradores'];
$moradia = $_POST['tipo_moradia'];
$internet = $_POST['possui_internet'];
$ps = $_POST['recebe_ps'];

$check2 = mysqli_query($conexao, "SELECT * FROM socioeconomico WHERE id_aluno_fk='$id'");

if(mysqli_num_rows($check2)){
    mysqli_query($conexao, "UPDATE socioeconomico SET
    renda_familiar='$renda',
    numero_moradores='$moradores',
    tipo_moradia='$moradia',
    possui_internet='$internet',
    recebe_ps='$ps'
    WHERE id_aluno_fk='$id'");
}else{
    mysqli_query($conexao, "INSERT INTO socioeconomico
    (renda_familiar,numero_moradores,tipo_moradia,possui_internet,recebe_ps,id_aluno_fk)
    VALUES
    ('$renda','$moradores','$moradia','$internet','$ps','$id')");
}

header("Location: perfil_aluno.php?id=$id");