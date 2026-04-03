<?php
require_once 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;

session_start();
include('conexao.php');

if(!isset($_SESSION['email'])){
    header('Location: index.php');
    exit();
}

if(!isset($_GET['id'])){
    die("ID não informado");
}

$id = intval($_GET['id']);

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
$aluno = mysqli_fetch_assoc($result);

$html = "
<h2 style='text-align:center;'>Perfil do Aluno</h2>
<hr>

<h3>Dados do Aluno</h3>
<p><strong>Nome:</strong> {$aluno['nome']}</p>
<p><strong>Data Nasc:</strong> {$aluno['data_nasc']}</p>
<p><strong>Sexo:</strong> {$aluno['sexo']}</p>
<p><strong>CPF:</strong> {$aluno['cpf']}</p>
<p><strong>Telefone:</strong> {$aluno['telefone']}</p>

<hr>

<h3>Saúde</h3>
<p><strong>Deficiência:</strong> " . ($aluno['possui_deficiencia'] ? 'Sim' : 'Não') . "</p>
<p><strong>Alergia:</strong> " . ($aluno['possui_alergia'] ? 'Sim' : 'Não') . "</p>
<p><strong>Medicação:</strong> " . ($aluno['uso_medicacao'] ? 'Sim' : 'Não') . "</p>

<hr>

<h3>Socioeconômico</h3>
<p><strong>Renda:</strong> {$aluno['renda_familiar']}</p>
<p><strong>Moradores:</strong> {$aluno['numero_moradores']}</p>
<p><strong>Moradia:</strong> {$aluno['tipo_moradia']}</p>
";

$dompdf = new Dompdf();
$dompdf->loadHtml($html);

$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

$dompdf->stream("aluno_$id.pdf", ["Attachment" => false]);