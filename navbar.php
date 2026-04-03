<?php
if(!isset($_SESSION)) session_start();

$tipo = $_SESSION['tipoLogin'] ?? null;
$email = $_SESSION['email'] ?? 'Usuário';
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">

        <!-- logo / home -->
        <a class="navbar-brand" href="
        <?php 
        if($tipo == 0) echo 'admin.php';
        elseif($tipo == 1) echo 'painel_coordenador.php';
        else echo 'painel_secretario.php';
        ?>
        ">
            Sistema de Matrículas
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">

            <ul class="navbar-nav me-auto">

                <?php if($tipo == 0): ?>
                    <!-- adm -->
                    <li class="nav-item">
                        <a class="nav-link" href="admin.php">Usuários</a>
                    </li>

                <?php elseif($tipo == 1): ?>
                    <!-- coordenador -->
                    <li class="nav-item">
                        <a class="nav-link" href="painel_coordenador.php">Home</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="lista_alunos.php">Lista de Alunos</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php">Dashboards</a>
                    </li>

                <?php elseif($tipo == 2): ?>
                    <!-- secretario -->
                    <li class="nav-item">
                        <a class="nav-link" href="painel_secretario.php">Home</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="matricular_aluno.php">Matricular Aluno</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="lista_alunos.php">Lista de Alunos</a>
                    </li>

                <?php endif; ?>

            </ul>

            <!-- lado direito -->
            <div class="d-flex align-items-center">

                <!-- email -->
                <span class="text-white me-3">
                    <?php echo $email; ?>
                </span>

                <!-- voltar -->
                <a href="javascript:history.back()" class="btn btn-outline-light me-2">
                    Voltar
                </a>

                <!-- sair -->
                <a class="btn btn-outline-danger" href="logout.php">
                    Sair
                </a>

            </div>

        </div>
    </div>
</nav>