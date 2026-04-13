<?php
include('conexao.php');
header('Content-Type: application/json');

$principal = $_POST['principal'] ?? 'possui_deficiencia';
$extras = $_POST['extras'] ?? [];
$tipo = $_POST['tipo'] ?? 'bar';

$stats = [
    'total' => mysqli_fetch_assoc(mysqli_query($conexao, "SELECT COUNT(*) as t FROM aluno"))['t'],
    'alergia' => mysqli_fetch_assoc(mysqli_query($conexao, "SELECT COUNT(*) as t FROM saude WHERE possui_alergia=1"))['t'],
    'defic' => mysqli_fetch_assoc(mysqli_query($conexao, "SELECT COUNT(*) as t FROM saude WHERE possui_deficiencia=1"))['t'],
    'medic' => mysqli_fetch_assoc(mysqli_query($conexao, "SELECT COUNT(*) as t FROM saude WHERE uso_medicacao=1"))['t'],
];

$colunas_map = [
    'nome' => 'a.nome',
    'sexo' => 'a.sexo',
    'cpf' => 'a.cpf',
    'telefone' => 'a.telefone',
    'possui_deficiencia' => 's.possui_deficiencia',
    'tipo_deficiencia' => 's.tipo_deficiencia',
    'possui_alergia' => 's.possui_alergia',
    'uso_medicacao' => 's.uso_medicacao',
    'renda_familiar' => 'se.renda_familiar'
];

$select = ["a.nome"];
if(isset($colunas_map[$principal])) $select[] = $colunas_map[$principal] . " AS $principal";

foreach($extras as $e){
    if(isset($colunas_map[$e])) $select[] = $colunas_map[$e] . " AS $e";
}

$sql = "SELECT " . implode(", ", $select) . " 
        FROM aluno a 
        LEFT JOIN saude s ON s.id_aluno_fk = a.id_aluno_pk 
        LEFT JOIN socioeconomico se ON se.id_aluno_fk = a.id_aluno_pk";

$res = mysqli_query($conexao, $sql);
$dados = [];
while($row = mysqli_fetch_assoc($res)) $dados[] = $row;

echo json_encode(['stats' => $stats, 'dados' => $dados]);