<?php
session_start();
if (!isset($_SESSION["login"]) || $_SESSION["login"] != true) {
    header("Location: index.php", true, 302);
    die();
}

// Necesitamos la variable que nos facilita conexion de la base de datos: $con
require_once "../../DB/conexion.php";


require_once "slug.php";

// IF que solo se ejecuta si hay POST enviar (es el submit input)
if (isset($_POST["enviar"])) {
    /**
     * @todo Asegurarnos que las 6 variables siguientes son aptas, es decir, not-empty o... con valores raros o SQL code (injection...)
     */
    $nombre = $_POST["nombre"];
    $url = slugify($nombre);

    // Preparamos la fecha para el SQL
    $datetimeHoy = new \Datetime("now");
    $fechaHoy = date("Y-m-d H:i:s", $datetimeHoy->getTimestamp());

    // Preparamos el SQL
    $sql = sprintf(
        "INSERT INTO `categoria` (`idcategoria`, `nombre`, `slug`, `fecha`) VALUES (%s, '%s', '%s', '%s');",
        "NULL",
        $nombre,
        $url,
        $fechaHoy
    );

    // Ejecutamos el SQL con la respectiva conexion ($con)
    $resultadoDelQuery = mysqli_query($con, $sql);

    // la variable que esto devuelve no la necesitamos para nada  de momento pero ahi queda... servira para ver si no ha guardado el INSERT,
    // mostrar un mensaje rollo 'Intentelo de nuevo mas tarde o contacte con el administrador'

    // si hay error de cualquier tipo, mostramos un mensaje, en caso contrario mostramos otro
    $mensaje = "Categoría creada correctamente: " . $_POST["nombre"];
    if (mysqli_errno($con)) {
        print_r(mysqli_error($con));
        $mensaje = "Inténtelo de nuevo más tarde o contacte con el administrador.";
    }

    echo "<h1>" . $mensaje . "</h1>";

    // Cerramos la conexion porque hemos acabado
    mysqli_close($con);

    header("Location: gestionCategorias.php", true, 302);
    die();
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>Crear post - Gestor</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/fontawesome-all.css">
    <link rel="stylesheet" href="../css/style.css">
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
                        <a href="logout.php" class="align-middle"><i class="fas fa-sign-out-alt"></i> Cerrar sesion</a>
                    </div>
                </div>
            </header>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-5 text-left">
                <i class="fas fa-home fa-2x"></i><br />
                <a href="gestion.php">MENÚ PRINCIPAL</a>
            </div>
        </div>
        <div class="row">
            <div class="col-s-12 col-md-9 mx-auto mt-4">
                <a href="gestionCategorias.php" class="confirmacion">VOLVER AL MENÚ DE GESTIÓN</a>

                <div id="form-container" class="container">
                    <form action="crear-categoria.php" method="post" enctype="multipart/form-data">
                        <h2 class="text-center">Crear categoría</h2>
                        <div class="row">
                            <div class="col-xsl-12 mx-auto">
                                <div class="form-group">
                                    <label for="nombre">Nombre:</label>
                                    <input class="form-control" type="text" name="nombre" id="nombre" required>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary" type="submit" name="enviar">Crear</button>
                                </div>
                            </div>
                        </div>  
                    </form>
                </div>
            </div>
        </div>
    </div>


<script type="text/javascript">
    var elemento = document.getElementsByClassName('confirmacion');
    var confirmar = function (e) {
        if (!confirm('¿Seguro que quieres volver atrás? \n Los cambios que hayas hecho no se guardarán.')) e.preventDefault();
    };
    for (var i = 0, l = elemento.length; i < l; i++) {
        elemento[i].addEventListener('click', confirmar, false);
    }
</script>
