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
$sql = "SELECT a.*, s.*, se.* FROM aluno a LEFT JOIN saude s ON s.id_aluno_fk = a.id_aluno_pk LEFT JOIN socioeconomico se ON se.id_aluno_fk = a.id_aluno_pk WHERE a.id_aluno_pk = '$id'";
$result = mysqli_query($conexao, $sql);
$aluno = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Editar Aluno</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script>
function toggleCampo(select, campoId){
    let campo = document.getElementById(campoId);
    campo.style.display = (select.value == "1") ? "block" : "none";
}
window.onload = function() {
    toggleCampo(document.querySelector('select[name="possui_deficiencia"]'), 'deficienciaCampo');
    toggleCampo(document.querySelector('select[name="possui_alergia"]'), 'alergiaCampo');
    toggleCampo(document.querySelector('select[name="uso_medicacao"]'), 'medicacaoCampo');
    toggleCampo(document.getElementById('restricao_select'), 'restricaoCampo');
};
</script>
</head>

<body class="bg-light">

<?php include('navbar.php'); ?>

<div class="container mt-5 mb-5">
    <h2 class="mb-4 text-center fw-bold text-success">Editar Informações do Aluno</h2>

    <form action="atualizar_aluno.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $id; ?>">

        <div class="card shadow-sm mb-4 border-0">
            <div class="card-header bg-success text-white fw-bold">Dados Pessoais</div>
            <div class="card-body row">
                <div class="col-md-6 mb-3">
                    <label class="fw-bold">Nome Completo</label>
                    <input class="form-control" name="nome" value="<?php echo htmlspecialchars($aluno['nome']); ?>" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="fw-bold">Data de Nascimento</label>
                    <input class="form-control" type="date" name="data_nasc" value="<?php echo $aluno['data_nasc']; ?>" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="fw-bold">Sexo</label>
                    <select class="form-control" name="sexo">
                        <option value="Masculino" <?php if($aluno['sexo']=='Masculino') echo 'selected'; ?>>Masculino</option>
                        <option value="Feminino" <?php if($aluno['sexo']=='Feminino') echo 'selected'; ?>>Feminino</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="fw-bold">CPF</label>
                    <input class="form-control" name="cpf" value="<?php echo $aluno['cpf']; ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="fw-bold">RG</label>
                    <input class="form-control" name="rg" value="<?php echo $aluno['rg']; ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="fw-bold">Telefone</label>
                    <input class="form-control" name="telefone" value="<?php echo $aluno['telefone']; ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="fw-bold">Escola de Origem</label>
                    <input class="form-control" name="escola_origem" value="<?php echo $aluno['escola_origem']; ?>">
                </div>
                <div class="col-md-12 mb-3">
                    <label class="fw-bold">Endereço Completo</label>
                    <input class="form-control" name="endereco" value="<?php echo $aluno['endereco']; ?>">
                </div>
            </div>
        </div>

        <div class="card shadow-sm mb-4 border-0">
            <div class="card-header bg-danger text-white fw-bold">Dados de Saúde</div>
            <div class="card-body row">
                <div class="col-md-6 mb-3">
                    <label class="fw-bold">Possui deficiência?</label>
                    <select class="form-control" name="possui_deficiencia" onchange="toggleCampo(this, 'deficienciaCampo')">
                        <option value="0" <?php if(!$aluno['possui_deficiencia']) echo 'selected'; ?>>Não</option>
                        <option value="1" <?php if($aluno['possui_deficiencia']) echo 'selected'; ?>>Sim</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3" id="deficienciaCampo">
                    <label class="fw-bold text-danger">Qual deficiência?</label>
                    <input class="form-control" name="tipo_deficiencia" value="<?php echo htmlspecialchars($aluno['tipo_deficiencia'] ?? ''); ?>">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="fw-bold">Possui alergia?</label>
                    <select class="form-control" name="possui_alergia" onchange="toggleCampo(this, 'alergiaCampo')">
                        <option value="0" <?php if(!$aluno['possui_alergia']) echo 'selected'; ?>>Não</option>
                        <option value="1" <?php if($aluno['possui_alergia']) echo 'selected'; ?>>Sim</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3" id="alergiaCampo">
                    <label class="fw-bold text-danger">Qual alergia?</label>
                    <input class="form-control" name="tipo_alergia" value="<?php echo htmlspecialchars($aluno['tipo_alergia'] ?? ''); ?>">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="fw-bold">Faz uso de medicação contínua?</label>
                    <select class="form-control" name="uso_medicacao" onchange="toggleCampo(this, 'medicacaoCampo')">
                        <option value="0" <?php if(!$aluno['uso_medicacao']) echo 'selected'; ?>>Não</option>
                        <option value="1" <?php if($aluno['uso_medicacao']) echo 'selected'; ?>>Sim</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3" id="medicacaoCampo">
                    <label class="fw-bold text-danger">Qual medicação?</label>
                    <input class="form-control" name="tipo_medicacao" value="<?php echo htmlspecialchars($aluno['tipo_medicacao'] ?? ''); ?>">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="fw-bold">Possui restrição alimentar?</label>
                    <select class="form-control" id="restricao_select" onchange="toggleCampo(this, 'restricaoCampo')">
                        <option value="0" <?php if(empty($aluno['restricao_alimentar'])) echo 'selected'; ?>>Não</option>
                        <option value="1" <?php if(!empty($aluno['restricao_alimentar'])) echo 'selected'; ?>>Sim</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3" id="restricaoCampo">
                    <label class="fw-bold text-danger">Qual restrição?</label>
                    <input class="form-control" name="restricao_alimentar" value="<?php echo htmlspecialchars($aluno['restricao_alimentar'] ?? ''); ?>">
                </div>
            </div>
        </div>

        <div class="card shadow-sm mb-4 border-0">
            <div class="card-header bg-warning text-dark fw-bold">Perfil Socioeconômico</div>
            <div class="card-body row">
                <div class="col-md-6 mb-3">
                    <label class="fw-bold">Renda Familiar</label>
                    <select class="form-control" name="renda_familiar">
                        <option value="Até R$ 1.000" <?php if($aluno['renda_familiar'] == 'Até R$ 1.000') echo 'selected'; ?>>Até R$ 1.000</option>
                        <option value="R$ 1.001 a R$ 2.000" <?php if($aluno['renda_familiar'] == 'R$ 1.001 a R$ 2.000') echo 'selected'; ?>>R$ 1.001 a R$ 2.000</option>
                        <option value="R$ 2.001 a R$ 5.000" <?php if($aluno['renda_familiar'] == 'R$ 2.001 a R$ 5.000') echo 'selected'; ?>>R$ 2.001 a R$ 5.000</option>
                        <option value="Acima de R$ 5.000" <?php if($aluno['renda_familiar'] == 'Acima de R$ 5.000') echo 'selected'; ?>>Acima de R$ 5.000</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="fw-bold">Número de Moradores</label>
                    <input class="form-control" name="numero_moradores" value="<?php echo $aluno['numero_moradores']; ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="fw-bold">Tipo de Moradia</label>
                    <select class="form-control" name="tipo_moradia">
                        <option value="Casa" <?php if($aluno['tipo_moradia'] == 'Casa') echo 'selected'; ?>>Casa</option>
                        <option value="Apartamento" <?php if($aluno['tipo_moradia'] == 'Apartamento') echo 'selected'; ?>>Apartamento</option>
                        <option value="Outro" <?php if($aluno['tipo_moradia'] == 'Outro') echo 'selected'; ?>>Outro</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="fw-bold">Possui internet?</label>
                    <select class="form-control" name="possui_internet">
                        <option value="0" <?php if(!$aluno['possui_internet']) echo 'selected'; ?>>Não</option>
                        <option value="1" <?php if($aluno['possui_internet']) echo 'selected'; ?>>Sim</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="fw-bold">Recebe Bolsa/Auxílio?</label>
                    <select class="form-control" name="recebe_ps">
                        <option value="0" <?php if(!$aluno['recebe_ps']) echo 'selected'; ?>>Não</option>
                        <option value="1" <?php if($aluno['recebe_ps']) echo 'selected'; ?>>Sim</option>
                    </select>
                </div>
            </div>
        </div>

        <button class="btn btn-success btn-lg w-100 shadow-sm fw-bold">Salvar Alterações</button>
    </form>
</div>
</body>
</html>