<?php
session_start();
include('conexao.php');

if(!isset($_SESSION['email']) || $_SESSION['tipoLogin'] != 2){
    header('Location: index.php');
    exit();
}


$nome = $_POST['nome'];
$data_nasc = $_POST['data_nasc'];
$sexo = $_POST['sexo'];
$cpf = preg_replace('/\D/', '', $_POST['cpf']); // remove pontos/traços
$telefone = preg_replace('/\D/', '', $_POST['telefone']);
$rg = $_POST['rg'];
$endereco = $_POST['endereco'];
$escola_origem = $_POST['escola_origem'];

$sql_aluno = "INSERT INTO Aluno (nome, data_nasc, sexo, cpf, rg, endereco, telefone, escola_origem) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conexao->prepare($sql_aluno);
$stmt->bind_param("ssssssss", $nome, $data_nasc, $sexo, $cpf, $rg, $endereco, $telefone, $escola_origem);

if(!$stmt->execute()){
    die("Erro ao cadastrar aluno: " . $conexao->error);
}

$id_aluno = $conexao->insert_id;


$possui_deficiencia = $_POST['possui_deficiencia'] ?? 0;
$tipo_deficiencia = $_POST['tipo_deficiencia'] ?? '';
$possui_alergia = $_POST['possui_alergia'] ?? 0;
$tipo_alergia = $_POST['tipo_alergia'] ?? '';
$uso_medicacao = $_POST['uso_medicacao'] ?? 0;
$tipo_medicacao = $_POST['tipo_medicacao'] ?? '';
$restricao_alimentar = $_POST['restricao_alimentar'] ?? '';

$sql_saude = "INSERT INTO saude (possui_deficiencia, tipo_deficiencia, possui_alergia, tipo_alergia, uso_medicacao, tipo_medicacao, restricao_alimentar, id_aluno_fk) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmt_saude = $conexao->prepare($sql_saude);
$stmt_saude->bind_param("isissisi", $possui_deficiencia, $tipo_deficiencia, $possui_alergia, $tipo_alergia, $uso_medicacao, $tipo_medicacao, $restricao_alimentar, $id_aluno);

if(!$stmt_saude->execute()){
    die("Erro na saúde: " . $conexao->error);
}


$renda_familiar = $_POST['renda_familiar'] ?? '';
$numero_moradores = $_POST['numero_moradores'] ?? 0;
$tipo_moradia = $_POST['tipo_moradia'] ?? '';
$possui_internet = $_POST['possui_internet'] ?? 0;
$recebe_ps = $_POST['recebe_ps'] ?? 0;

$sql_socio = "INSERT INTO socioeconomico (renda_familiar, numero_moradores, tipo_moradia, possui_internet, recebe_ps, id_aluno_fk) VALUES (?, ?, ?, ?, ?, ?)";
$stmt_socio = $conexao->prepare($sql_socio);
$stmt_socio->bind_param("sisiii", $renda_familiar, $numero_moradores, $tipo_moradia, $possui_internet, $recebe_ps, $id_aluno);

if(!$stmt_socio->execute()){
    die("Erro socioeconômico: " . $conexao->error);
}

header('Location: lista_alunos.php?sucesso=1');
exit();
?>