<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<title>Modificar categoría - Gestor</title>
	<link rel="stylesheet" href="../css/bootstrap.min.css">
	<link rel="stylesheet" href="../css/fontawesome-all.css">
	<link rel="stylesheet" href="../css/style.css">

	<?php
	session_start();
	if (!isset($_SESSION["login"]) || $_SESSION["login"] != true) {
		header("Location: index.php", true, 302);
		die();
	}

	include_once '../../DB/conexion.php';

	?>

</head>
<body>
	<div class="container-fluid">
		<div class="row">
			<header class="col-12">
				<div class="row">
					<div class="col-8" class="align-middle">
						<h1>Bienvenido, <?= $_SESSION["username"] ?></h1>
					</div>
					<div class="col-4">						
						<a href="logout.php" class=""><i class="fas fa-sign-out-alt"></i>Cerrar sesion</a>
					</div>
				</div>
			</header>
		</div>
	</div>

	<div class="container-fluid">
		<div class="row">
			<div class="col-s-12 col-md-7 mx-auto mt-4">
				<div class="row flex-wrap">
					<div class="col-6 accion">
						<img src="../images/ordenador.png" alt="" class="img-fluid rounded">
					</div>
					<div class="col-6 accion">
						<div class="row">
							<div class="col-s-12 col-md-6" style="background-color: pink;">						
								<a href="gestionPosts.php" class="btn btn-primary btn-lg " role="button">Gestionar posts</a>
							</div>
							<div class="col-s-12 col-md-6">						
								<a href="gestionCategorias.php" class="btn btn-primary btn-lg" role="button">Gestionar categorías</a>
							</div>	
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script>

	</script>
</body>
</html>

