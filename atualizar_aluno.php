<?php
session_start();
include('conexao.php');

if(!isset($_SESSION['email']) || $_SESSION['tipoLogin'] != 2){
    header('Location: index.php');
    exit();
}

if(!isset($_POST['id'])){
    header('Location: lista_alunos.php');
    exit();
}

$id = $_POST['id'];

//dados do aluno

$nome = mysqli_real_escape_string($conexao, $_POST['nome']);
$data_nasc = $_POST['data_nasc'];
$sexo = $_POST['sexo'];

$cpf = preg_replace('/\D/', '', $_POST['cpf']);
$telefone = preg_replace('/\D/', '', $_POST['telefone']);

$rg = $_POST['rg'];
$endereco = $_POST['endereco'];
$escola_origem = $_POST['escola_origem'];

$sql_aluno = "UPDATE aluno SET 
    nome='$nome',
    data_nasc='$data_nasc',
    sexo='$sexo',
    cpf='$cpf',
    rg='$rg',
    endereco='$endereco',
    telefone='$telefone',
    escola_origem='$escola_origem'
WHERE id_aluno_pk='$id'";

if(!mysqli_query($conexao, $sql_aluno)){
    die("Erro aluno: " . mysqli_error($conexao));
}

//saude

$possui_deficiencia = $_POST['possui_deficiencia'] ?? 0;
$tipo_deficiencia = $_POST['tipo_deficiencia'] ?? '';

$possui_alergia = $_POST['possui_alergia'] ?? 0;
$tipo_alergia = $_POST['tipo_alergia'] ?? '';

$uso_medicacao = $_POST['uso_medicacao'] ?? 0;
$tipo_medicacao = $_POST['tipo_medicacao'] ?? '';

$restricao_alimentar = $_POST['restricao_alimentar'] ?? '';

$sql_check_saude = "SELECT id_saude_pk FROM saude WHERE id_aluno_fk='$id'";
$result_saude = mysqli_query($conexao, $sql_check_saude);

if(mysqli_num_rows($result_saude) > 0){
    // atualizar dados
    $sql_saude = "UPDATE saude SET
        possui_deficiencia='$possui_deficiencia',
        tipo_deficiencia='$tipo_deficiencia',
        possui_alergia='$possui_alergia',
        tipo_alergia='$tipo_alergia',
        uso_medicacao='$uso_medicacao',
        tipo_medicacao='$tipo_medicacao',
        restricao_alimentar='$restricao_alimentar'
    WHERE id_aluno_fk='$id'";
} else {
    // inserir
    $sql_saude = "INSERT INTO saude
    (possui_deficiencia, tipo_deficiencia, possui_alergia, tipo_alergia, uso_medicacao, tipo_medicacao, restricao_alimentar, id_aluno_fk)
    VALUES
    ('$possui_deficiencia', '$tipo_deficiencia', '$possui_alergia', '$tipo_alergia', '$uso_medicacao', '$tipo_medicacao', '$restricao_alimentar', '$id')";
}

if(!mysqli_query($conexao, $sql_saude)){
    die("Erro saúde: " . mysqli_error($conexao));
}

//socioeconomco

$renda_familiar = $_POST['renda_familiar'] ?? '';
$numero_moradores = $_POST['numero_moradores'] ?? '';
$tipo_moradia = $_POST['tipo_moradia'] ?? '';
$possui_internet = $_POST['possui_internet'] ?? 0;
$recebe_ps = $_POST['recebe_ps'] ?? 0;

$sql_check_socio = "SELECT id_se_pk FROM socioeconomico WHERE id_aluno_fk='$id'";
$result_socio = mysqli_query($conexao, $sql_check_socio);

if(mysqli_num_rows($result_socio) > 0){
    // atualizar dados
    $sql_socio = "UPDATE socioeconomico SET
        renda_familiar='$renda_familiar',
        numero_moradores='$numero_moradores',
        tipo_moradia='$tipo_moradia',
        possui_internet='$possui_internet',
        recebe_ps='$recebe_ps'
    WHERE id_aluno_fk='$id'";
} else {
    // inserir
    $sql_socio = "INSERT INTO socioeconomico
    (renda_familiar, numero_moradores, tipo_moradia, possui_internet, recebe_ps, id_aluno_fk)
    VALUES
    ('$renda_familiar', '$numero_moradores', '$tipo_moradia', '$possui_internet', '$recebe_ps', '$id')";
}

if(!mysqli_query($conexao, $sql_socio)){
    die("Erro socioeconômico: " . mysqli_error($conexao));
}



header("Location: perfil_aluno.php?id=$id");
exit();
?>