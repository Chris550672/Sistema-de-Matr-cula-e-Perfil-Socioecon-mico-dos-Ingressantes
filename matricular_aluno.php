<?php
session_start();
require_once 'config.php';

if(!isset($_SESSION['email']) || $_SESSION['tipoLogin'] != 2){
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Matricular Aluno - <?php echo SISTEMA_NOME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">

<?php include('navbar.php'); ?>

<div class="container my-4">
    <div class="text-center mb-4">
        <h1 class="fw-bold text-success"><?php echo NOME_ESCOLA; ?></h1>
        <p class="text-muted">Formulário de Matrícula - <?php echo SISTEMA_NOME; ?></p>
    </div>

    <form action="salvar_aluno.php" method="POST">
        
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-success text-white fw-bold">
                <i class="bi bi-person-fill"></i> Dados do Aluno
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Nome Completo</label>
                    <input type="text" class="form-control" name="nome" required>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Data de Nascimento</label>
                        <input type="date" class="form-control" name="data_nasc" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Sexo</label>
                        <select class="form-select" name="sexo" required>
                            <option value="">Selecione</option>
                            <option value="Masculino">Masculino</option>
                            <option value="Feminino">Feminino</option>
                            <option value="Outro">Outro</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">CPF</label>
                        <input type="text" class="form-control cpf" name="cpf" placeholder="000.000.000-00" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">RG</label>
                        <input type="text" class="form-control rg" name="rg" placeholder="Somente números" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Endereço Completo</label>
                    <input type="text" class="form-control" name="endereco" placeholder="Rua, Número, Bairro...">
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Telefone</label>
                        <input type="text" class="form-control telefone" name="telefone" placeholder="(00) 00000-0000">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Escola de Origem</label>
                        <input type="text" class="form-control" name="escola_origem">
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-header bg-info text-white fw-bold">
                <i class="bi bi-heart-pulse-fill"></i> Informações de Saúde
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Possui Deficiência?</label>
                        <select class="form-select" name="possui_deficiencia" onchange="toggleCampo(this, 'deficienciaCampo')">
                            <option value="0">Não</option>
                            <option value="1">Sim</option>
                        </select>
                        <div id="deficienciaCampo" class="mt-2" style="display:none;">
                            <input type="text" class="form-control" name="tipo_deficiencia" placeholder="Especifique a deficiência">
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Possui Alergia?</label>
                        <select class="form-select" name="possui_alergia" onchange="toggleCampo(this, 'alergiaCampo')">
                            <option value="0">Não</option>
                            <option value="1">Sim</option>
                        </select>
                        <div id="alergiaCampo" class="mt-2" style="display:none;">
                            <input type="text" class="form-control" name="tipo_alergia" placeholder="Especifique a alergia">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-header bg-secondary text-white fw-bold">
                <i class="bi bi-cash-stack"></i> Socioeconômico
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Renda Familiar</label>
                        <select class="form-select" name="renda_familiar">
                            <option value="">Selecione</option>
                            <option value="Até R$ 1.000">Até R$ 1.000</option>
                            <option value="R$ 1.001 a R$ 2.000">R$ 1.001 a R$ 2.000</option>
                            <option value="Acima de R$ 2.000">Acima de R$ 2.000</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Internet em casa?</label>
                        <select class="form-select" name="possui_internet">
                            <option value="0">Não</option>
                            <option value="1">Sim</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Recebe Auxílio Governamental?</label>
                        <select class="form-select" name="recebe_ps">
                            <option value="0">Não</option>
                            <option value="1">Sim</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-success btn-lg w-100 shadow">
            <i class="bi bi-check-circle"></i> Finalizar Matrícula
        </button>

    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function(){
    // mascaras (+ seguro)
    $('.cpf').mask('000.000.000-00');
    $('.telefone').mask('(00) 00000-0000');
    $('.rg').mask('00000000000000', {reverse: true}); // ex de rg longo
});

function toggleCampo(select, campoId){
    let campo = document.getElementById(campoId);
    campo.style.display = (select.value == "1") ? "block" : "none";
}
</script>

</body>
</html>