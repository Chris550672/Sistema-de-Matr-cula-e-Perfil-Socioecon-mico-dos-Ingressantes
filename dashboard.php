<?php
session_start();
if(!isset($_SESSION['email']) || $_SESSION['tipoLogin'] != 1){
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Estratégico</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root { --seduc-green: #198754; --seduc-dark: #145c32; }
        .card-stats { border-top: 4px solid var(--seduc-green); }
        .chart-container { position: relative; height: 350px; }
        .table-preview { font-size: 0.9rem; }
        .sidebar-filters { background: #fff; border-radius: 10px; padding: 20px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
    </style>
</head>
<body class="bg-light">

<?php include('navbar.php'); ?>

<div class="container-fluid px-4 mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-success"><i class="bi bi-bar-chart-steps me-2"></i>Dashboard de Inteligência Escolar</h2>
        <button class="btn btn-success" onclick="window.print()"><i class="bi bi-printer me-2"></i>Imprimir Relatório</button>
    </div>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm card-stats text-center p-3">
                <h6 class="text-muted text-uppercase">Total de Alunos</h6>
                <h3 class="fw-bold" id="kpi-total">...</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm card-stats text-center p-3" style="border-top-color: #dc3545;">
                <h6 class="text-muted text-uppercase">Casos de Alergia</h6>
                <h3 class="fw-bold text-danger" id="kpi-alergia">...</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm card-stats text-center p-3" style="border-top-color: #ffc107;">
                <h6 class="text-muted text-uppercase">Com Deficiência</h6>
                <h3 class="fw-bold text-warning" id="kpi-defic">...</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm card-stats text-center p-3" style="border-top-color: #0dcaf0;">
                <h6 class="text-muted text-uppercase">Uso de Medicação</h6>
                <h3 class="fw-bold text-info" id="kpi-medic">...</h3>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-3">
            <div class="sidebar-filters shadow-sm">
                <h5 class="fw-bold mb-3"><i class="bi bi-funnel me-2"></i>Filtros</h5>
                
                <label class="form-label fw-bold small">Modo de Exibição</label>
                <select id="tipoVisu" class="form-select mb-3">
                    <option value="bar">Gráfico de Barras</option>
                    <option value="pie">Gráfico de Pizza</option>
                    <option value="doughnut">Gráfico de Rosca</option>
                    <option value="tabela">Tabela Detalhada</option>
                </select>

                <label class="form-label fw-bold small">Informação Principal</label>
                <select id="colunaPrincipal" class="form-select mb-3">
                    <option value="possui_deficiencia">Deficiências</option>
                    <option value="possui_alergia">Alergias</option>
                    <option value="uso_medicacao">Uso de Medicação</option>
                    <option value="renda_familiar">Renda Familiar</option>
                    <option value="sexo">Gênero</option>
                </select>

                <hr>
                <label class="form-label fw-bold small">Colunas Extras (Para Tabela)</label>
                <div class="mb-3">
                    <div class="form-check"> <input class="form-check-input chk-col" type="checkbox" value="cpf"> <label class="small">CPF</label> </div>
                    <div class="form-check"> <input class="form-check-input chk-col" type="checkbox" value="telefone"> <label class="small">Telefone</label> </div>
                    <div class="form-check"> <input class="form-check-input chk-col" type="checkbox" value="tipo_deficiencia"> <label class="small">Tipo Defic.</label> </div>
                </div>

                <button class="btn btn-success w-100 fw-bold" onclick="carregarDados()">
                    <i class="bi bi-arrow-clockwise me-1"></i> Atualizar Dados
                </button>
            </div>
        </div>

        <div class="col-lg-9">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div id="container-grafico" class="chart-container">
                        <canvas id="myChart"></canvas>
                    </div>
                    <div id="container-tabela" class="d-none">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped table-preview">
                                <thead class="table-dark" id="head-tabela"></thead>
                                <tbody id="body-tabela"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let chart = null;

window.onload = carregarDados;

function carregarDados() {
    const tipo = document.getElementById('tipoVisu').value;
    const principal = document.getElementById('colunaPrincipal').value;
    const extras = Array.from(document.querySelectorAll('.chk-col:checked')).map(c => c.value);

    fetch('processar_dashboard.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `tipo=${tipo}&principal=${principal}&extras[]=${extras.join('&extras[]=')}`
    })
    .then(r => r.json())
    .then(res => {
        document.getElementById('kpi-total').innerText = res.stats.total;
        document.getElementById('kpi-alergia').innerText = res.stats.alergia;
        document.getElementById('kpi-defic').innerText = res.stats.defic;
        document.getElementById('kpi-medic').innerText = res.stats.medic;

        if (tipo === 'tabela') {
            mostrarTabela(res.dados);
        } else {
            mostrarGrafico(res.dados, tipo, principal);
        }
    });
}

function mostrarTabela(dados) {
    document.getElementById('container-grafico').classList.add('d-none');
    document.getElementById('container-tabela').classList.remove('d-none');
    
    const head = document.getElementById('head-tabela');
    const body = document.getElementById('body-tabela');
    
    if(dados.length === 0) return;

    let cols = Object.keys(dados[0]);
    head.innerHTML = `<tr>${cols.map(c => `<th>${c.toUpperCase().replace('_', ' ')}</th>`).join('')}</tr>`;
    
    body.innerHTML = dados.map(row => `
        <tr>${cols.map(c => {
            let val = row[c];
            if(val === "1") return '<td><span class="badge bg-danger">Sim</span></td>';
            if(val === "0") return '<td><span class="badge bg-secondary">Não</span></td>';
            return `<td>${val || '-'}</td>`;
        }).join('')}</tr>
    `).join('');
}

function mostrarGrafico(dados, tipo, principal) {
    document.getElementById('container-tabela').classList.add('d-none');
    document.getElementById('container-grafico').classList.remove('d-none');

    const counts = {};
    dados.forEach(d => {
        let label = d[principal];
        if(label === "1") label = "Sim";
        else if(label === "0") label = "Não";
        else if(!label) label = "Não Informado";
        counts[label] = (counts[label] || 0) + 1;
    });

    const ctx = document.getElementById('myChart').getContext('2d');
    if(chart) chart.destroy();

    chart = new Chart(ctx, {
        type: tipo,
        data: {
            labels: Object.keys(counts),
            datasets: [{
                label: 'Qtd. Alunos',
                data: Object.values(counts),
                backgroundColor: ['#198754', '#ffc107', '#dc3545', '#0dcaf0', '#6610f2']
            }]
        },
        options: { 
            responsive: true, 
            maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom' } }
        }
    });
}
</script>
</body>
</html>