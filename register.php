<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Sistema de Matrículas</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .box {
            background-color: #ffffff;
            margin-top: 120px;
            padding: 30px;
            border-radius: 10px;
            border: 1px solid #ddd;
        }

        .btn-custom {
            background-color: transparent;
            border: 1px solid #333;
            color: #333;
        }

        .btn-custom:hover {
            background-color: #333;
            color: #fff;
        }

        .titulo {
            margin-top: 50px;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
        }

        .titulo span { /* esse span serve so pra qnd eu quiser
                            mexer em uma parte específica de um
                            texto invés de mexer nele todo */
            color: #555;
        }
    </style>
</head>
<body>

<div class="titulo">
    SISTEMA <span>DE MATRÍCULAS</span>
</div>

<div class="container d-flex justify-content-center">
    <div class="box col-md-4 text-center">

        <h4 class="mb-4">Entrar como:</h4>

        <form action="index.php" method="POST">

            <button type="submit" name="tipoLogin" value="0" class="btn btn-dark w-100 mb-3">
                Administrador
            </button>

            <button type="submit" name="tipoLogin" value="1" class="btn btn-custom w-100 mb-3">
                Coordenador
            </button>

            <button type="submit" name="tipoLogin" value="2" class="btn btn-custom w-100">
                Secretário
            </button>

        </form>

    </div>
</div>

</body>
</html>