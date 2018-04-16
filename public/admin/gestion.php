<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<title>Gestor del blog</title>
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
                    <div class="col-8">
                        <h1 class="p-4">Bienvenido, <?= $_SESSION["username"] ?></h1>
                    </div>
                    <div class="col-4 text-right mt-3">
                        <a href="logout.php" class="align-middle"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</a>
                    </div>
                </div>
            </header>
        </div>
    </div>

	<div class="container-fluid">
		<div class="row">
			<div class="col-s-12 col-md-8 mx-auto mt-4">
				<div class="row flex-wrap">
					<div class="col-s-12 col-md-5 accion">
						<img src="../images/ordenador.png" alt="" class="img-fluid rounded">
					</div>
					<div class="col-s-12 col-md-7 accion d-flex align-items-center">
						<div class="row">
							<div class="col-s-12 col-md-6 my-2">
								<a href="gestionPosts.php" class="btn btn-primary btn-lg align-self-center" role="button">Gestionar posts</a>
							</div>
							<div class="col-s-12 col-md-6 my-2">	
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

