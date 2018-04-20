<?php
session_start();
if (!isset($_SESSION["login"]) || $_SESSION["login"] != true) {
    header("Location: index.php", true, 302);
    die();
}

// Conectamos con la BD, que nos facilita la variable que nos permite la conexion de la base de datos: $con
require_once "../../DB/conexion.php";

//Nos sirve para transformar el nombre en una cadena para la url
require_once "slug.php";

// IF que solo se ejecuta si hay POST enviar (es el submit input)
if (isset($_POST["enviar"])) {
    $nombre = $_POST["nombre"];
    $url = slugify($nombre);

    /**
     * Validación de datos del formulario
     */
    $valido = true;
    $mensajeDeError = "";

    // El nombre no puede estar vacío
    if ("" == $nombre) {
        $valido = false;
        $mensajeDeError = "Por favor, especifique una categoría.";
    }

    // Si los datos introducidos en el formulario son válidos
    if ($valido) {

        // Preparamos la fecha para el SQL
        $datetimeHoy = new \Datetime("now");
        $fechaHoy = date("Y-m-d H:i:s", $datetimeHoy->getTimestamp());

        // Preparamos el SQL
        $sql = sprintf(
            "INSERT INTO `categoria` (`idcategoria`, `nombre`, `slug`, `fecha`) VALUES (%s, '%s', '%s', '%s');",
            "NULL",
            mres($nombre),
            mres($url),
            mres($fechaHoy)
        );

        // Ejecutamos el SQL con la respectiva conexion ($con)
        $resultadoDelQuery = mysqli_query($con, $sql);


        // Se muestran mensajes si ha ido bien o si ha habido algún error
        $mensaje = "Categoría creada correctamente: " . $_POST["nombre"];
        if (mysqli_errno($con)) {
            print_r(mysqli_error($con));
            $mensaje = "Inténtelo de nuevo más tarde o contacte con el administrador.";
        }

        echo "<h1>" . $mensaje . "</h1>";

        // Cerramos la conexión porque hemos acabado
        mysqli_close($con);

        header("Location: gestionCategorias.php", true, 302);
        die();
    }
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
                <a href="gestion.php" class="confirmacion"><i class="fas fa-home fa-2x"></i><br />INICIO</a>
            </div>
        </div>
        <div class="row">
            <div class="col-s-12 col-md-9 mx-auto mt-4">
                <a href="gestionCategorias.php" class="confirmacion"><i class="fas fa-arrow-alt-circle-left pl-3"></i> VOLVER A CATEGORÍAS</a>

                <div id="form-container" class="container">
                    <form action="crear-categoria.php" method="post" enctype="multipart/form-data">
                        <?php
                            if (isset($valido)) {
                                if ($valido === false) {
                                    ?>
                                    <div class="form-error"><?= $mensajeDeError ?></div>
                                    <?php
                                }
                            }
                        ?>
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
