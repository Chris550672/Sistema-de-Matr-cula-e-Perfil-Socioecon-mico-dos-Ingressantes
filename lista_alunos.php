<?php
session_start();
include('conexao.php');

$itens_por_pagina = isset($_GET['limite']) ? intval($_GET['limite']) : 20;
$pagina_atual = isset($_GET['pagina']) ? intval($_GET['pagina']) : 1;
if($pagina_atual < 1) $pagina_atual = 1;

$offset = ($pagina_atual - 1) * $itens_por_pagina;

$resultado_total = $conexao->query("SELECT COUNT(*) as total FROM aluno");
$total_alunos = $resultado_total->fetch_assoc()['total'];
$total_paginas = ceil($total_alunos / $itens_por_pagina);

$stmt = $conexao->prepare("SELECT * FROM aluno ORDER BY nome ASC LIMIT ? OFFSET ?");
$stmt->bind_param("ii", $itens_por_pagina, $offset);
$stmt->execute();
$alunos = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Lista de Alunos - <?php echo SISTEMA_NOME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">

<?php include('navbar.php'); ?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-people"></i> Alunos Cadastrados</h2>
        
        <div class="d-flex align-items-center">
            <span class="me-2">Mostrar:</span>
            <select class="form-select form-select-sm" style="width: auto;" onchange="location.href='?pagina=1&limite='+this.value">
                <option value="10" <?php if($itens_por_pagina == 10) echo 'selected'; ?>>10</option>
                <option value="20" <?php if($itens_por_pagina == 20) echo 'selected'; ?>>20</option>
                <option value="50" <?php if($itens_por_pagina == 50) echo 'selected'; ?>>50</option>
                <option value="100" <?php if($itens_por_pagina == 100) echo 'selected'; ?>>100</option>
            </select>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Nome</th>
                        <th>CPF</th>
                        <th>Telefone</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($aluno = $alunos->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $aluno['nome']; ?></td>
                        <td><?php echo $aluno['cpf']; ?></td>
                        <td><?php echo $aluno['telefone']; ?></td>
                        <td class="text-center">
                            <a href="visualizar_aluno.php?id=<?php echo $aluno['id_aluno_pk']; ?>" class="btn btn-sm btn-info text-white">
                                <i class="bi bi-eye"></i> Ver
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <nav class="mt-4">
        <ul class="pagination justify-content-center">
            <li class="page-item <?php echo ($pagina_atual <= 1) ? 'disabled' : ''; ?>">
                <a class="page-link" href="?pagina=<?php echo $pagina_atual - 1; ?>&limite=<?php echo $itens_por_pagina; ?>">Anterior</a>
            </li>

            <?php for($i = 1; $i <= $total_paginas; $i++): ?>
                <li class="page-item <?php echo ($i == $pagina_atual) ? 'active' : ''; ?>">
                    <a class="page-link" href="?pagina=<?php echo $i; ?>&limite=<?php echo $itens_por_pagina; ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>

            <li class="page-item <?php echo ($pagina_atual >= $total_paginas) ? 'disabled' : ''; ?>">
                <a class="page-link" href="?pagina=<?php echo $pagina_atual + 1; ?>&limite=<?php echo $itens_por_pagina; ?>">Próximo</a>
            </li>
        </ul>
    </nav>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>