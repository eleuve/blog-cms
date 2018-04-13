<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<title>Modificar categoría - Gestor</title>
	<link rel="stylesheet" href="../css/bootstrap.min.css">
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
				<h1>Bienvenido, <?= $_SESSION["username"] ?></h1>
				<a href="logout.php" class="">Cerrar sesion</a>
			</header>
		</div>
		<div class="row">
			<div class="col-s-12 col-md-7 mx-auto mt-4">
				<div class="row">
					<div class="col-6 accion">
						<a href="gestionPosts.php" class="btn btn-primary" role="button">Gestionar posts</a>
					</div>
					<div class="col-6 acciones">
						<a href="gestionCategorias.php" class="btn btn-primary" role="button">Gestionar categorías</a>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script>

	</script>
</body>
</html>

