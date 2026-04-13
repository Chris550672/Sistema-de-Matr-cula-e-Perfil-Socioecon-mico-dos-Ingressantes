<?php
session_start();
if(isset($_POST['tipoLogin'])){
    $_SESSION['tipoLogin'] = $_POST['tipoLogin'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<meta name="description" content="Login">
	<title>Sistema de Matrículas</title>

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">

	<style>
		body {
			background-color: #ffffff; /*cinza claro (acho q combina mais)*/
		}

		.card {
			background-color: #ffffff; /* branco (p combinar com o cinza claro)*/
			border: 1px solid #ddd;
			border-radius: 10px;
		}

		.card-title {
			text-align: center;
		}

		.logo {
			max-width: 250px;
		}
	</style>
</head>

<body>
	<section class="h-100">
		<div class="container h-100">
			<div class="row justify-content-sm-center h-100">

				<div class="col-xxl-4 col-xl-5 col-lg-5 col-md-7 col-sm-9">

					<div class="text-center my-5">
						<img src="logo_ep.png" alt="logo" class="logo">
					</div>

					<div class="card shadow">
						<div class="card-body p-5">
    								<h1 class="fs-4 card-title fw-bold mb-4">
    										Login - 
    											<?php 
        											$tipoLogin = $_SESSION['tipoLogin'] ?? null;

        										if ($tipoLogin == "2") {
            										echo "Secretário";
        										} elseif ($tipoLogin == "1") {						
												echo "Coordenador";
        										} elseif ($tipoLogin == "0") {
            										echo "Administrador";
        										} else {
            										echo "Usuário";
       											 }	
    											?>
											</h1>
							<form action="login.php" method="POST" class="needs-validation" novalidate autocomplete="off">

								<div class="mb-3">
									<label class="mb-2 text-muted">E-mail</label>
									<input type="email" class="form-control" name="email" required autofocus>
								</div>

								<div class="mb-3">
									<div class="mb-2 w-100">
										<label class="text-muted">Senha</label>
									</div>
									<input type="password" class="form-control" name="senha" required>
								</div>

								<div class="d-flex align-items-center">
									<div class="form-check">
										<input type="checkbox" id="remember" class="form-check-input">
										<label for="remember" class="form-check-label">Lembrar</label>
									</div>

									<button type="submit" class="btn btn-dark ms-auto">
										Entrar
									</button>
								</div> 

							</form>
						</div>

						<div class="card-footer py-3 border-0">
							<div class="text-center text-muted">
								Sistema Escolar
							</div>
						</div>
					</div>

					<div class="text-center mt-5 text-muted">
						© 2026 - Sistema de Matrículas EEEP
					</div>

				</div>
			</div>
		</div>
	</section>
</body>
</html>