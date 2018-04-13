<?php
session_start();
if (!isset($_SESSION["login"]) || $_SESSION["login"] != true) {
    header("Location: index.php", true, 302);
    die();
}

// Necesitamos la variable que nos facilita conexion de la base de datos: $con
require_once "../../DB/conexion.php";

// IF que solo se ejecuta si hay POST enviar (es el submit input)
if (isset($_POST["submit"])) {
    /**
     * @todo Asegurarnos que las 6 variables siguientes son aptas, es decir, not-empty o... con valores raros o SQL code (injection...)
     */
    $idCategoria = $_POST["categoria"];
    $titulo = $_POST["titulo"];
    $entradilla = $_POST["entradilla"];
    $file = $_FILES["imagen"];
    $html = $_POST["entrada"];
    $esPublico = "false";
    $altimagen = $_POST["altimagen"];

    if (isset($_POST["publico"])) {
        if ($_POST["publico"] == "público") {
            $esPublico = "true";
        }
    }

    /** Guardado del archivo en la carpeta /uploads */
    // El archivo se sube a una ruta temporal de PHP (a saber cual), no hay funcion MOVE en php, asi que leemos el contenido del archivo...
    $imageBinaryData = file_get_contents($file["tmp_name"]);
    // Crea el archivo en uploads, require 2 cosas: nombre de archivo, contenido
    file_put_contents('../uploads/' . $file["name"], $imageBinaryData);

    /** Como todo es correcto (validado empty & injections), ejecutamos un INSERT... */

    // Preparamos la fecha para el SQL
    $datetimeHoy = new \Datetime("now");
    $fechaHoy = date("Y-m-d H:i:s", $datetimeHoy->getTimestamp());

    // Preparamos el SQL
    $sql = sprintf(
        "INSERT INTO `post` (`idpost`, `titulo`, `entradilla`, `contenido`, `fecha`, `idcategoria`, `imagen`, `activo`, `altimagen`) VALUES (%s, '%s', '%s', '%s', '%s', '%s', '%s', %s, '%s')",
        "NULL",
        $titulo,
        $entradilla,
        $html,
        $fechaHoy,
        $idCategoria,
        $file["name"],
        $esPublico,
        $altimagen
    );

    // Ejecutamos el SQL con la respectiva conexion ($con)
    $resultadoDelQuery = mysqli_query($con, $sql);

    // la variable que esto devuelve no la necesitamos para nada  de momento pero ahi queda... servira para ver si no ha guardado el INSERT,
    // mostrar un mensaje rollo 'Intentelo de nuevo mas tarde o contacte con el administrador'

    // si hay error de cualquier tipo, mostramos un mensaje, en caso contrario mostramos otro
    $mensaje = "Post creado correctamente: " . $_POST["titulo"];
    if (mysqli_errno($con)) {
        print_r(mysqli_error($con));
        $mensaje = "Inténtelo de nuevo más tarde o contacte con el administrador.";
    }

    echo "<h1>" . $mensaje . "</h1>";

    // Cerramos la conexion porque hemos acabado
    mysqli_close($con);

    header("Location: gestionPosts.php", true, 302);
    die();
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>Modificar categoría - Gestor</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container-fluid">
        <header class="row">
            <div class="col-6">
                <h1>Bienvenido, <?= $_SESSION["username"] ?></h1>
            </div>
            <div class="col-6 text-right">
                <a href="logout.php">Cerrar sesion</a>
            </div>
        </header>
        <div>
            <i class="fas fa-arrow-circle-left"></i><br />
            <a href="gestion.php">VOLVER AL MENÚ PRINCIPAL</a>
        </div>
    </div>





    <div class="container-fluid">

        <div class="row">
            <div class="col-s-12 col-md-9 mx-auto mt-4">
                <a href="gestionPosts.php" class="confirmacion">VOLVER AL MENÚ DE GESTIÓN</a>

                <div id="form-container" class="container">
                    <form action="crear-post.php" method="post" enctype="multipart/form-data">

                        <div class="row">
                            <div class="col-xsl-12">
                                <div class="form-group">
                                    <label for="categoria">Categoría</label>
                                    <select class="form-control" name="categoria">
                                        <?php
                                        // Consultamos las categorias e iteramos sobre ellas para imprimir los <options> pertinentes.
                                        $resultado = mysqli_query($con, "SELECT * FROM categoria");
                                        while ($categoria = mysqli_fetch_array(
                                            $resultado,
                                            MYSQLI_ASSOC
                                        )) {
                                            ?><option value="<?= $categoria["idcategoria"] ?>"><?= $categoria["nombre"] ?></option><?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="titulo">Título</label>
                                    <input class="form-control" type="text" name="titulo">
                                </div>
                                <div class="form-group">
                                    <label for="">Entradilla</label>
                                    <input class="form-control" type="text" name="entradilla"><br/>
                                </div>
                                <div class="form-group">
                                    <label for="">Imagen</label>
                                    <input class="form-control" type="file" name="imagen"/><br/>
                                </div>
                                <div class="form-group">
                                    <label for="">Alt de la imagen</label>
                                    <input class="form-control" type="text" name="altimagen"/><br/>
                                </div>
                                <div class="form-group">
                                    <label for="entrada">Entrada</label>
                                    <textarea class="form-control" name="entrada">
                                        Whatever
                                    </textarea>
                                </div>
                                <div class="form-group">
                                    <input type="checkbox" name="publico" value="público" name="publico">Público<br><br/>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary" type="submit" name="submit">Crear</button>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="https://cdn.ckeditor.com/4.9.1/standard/ckeditor.js"></script>

    <script type="text/javascript">
        var elemento = document.getElementsByClassName('confirmacion');
        var confirmar = function (e) {
            if (!confirm('¿Seguro que quieres volver atrás? \n Los cambios que hayas hecho no se guardarán.')) e.preventDefault();
        };
        for (var i = 0, l = elemento.length; i < l; i++) {
            elemento[i].addEventListener('click', confirmar, false);
        }


    </script>
    <script type="text/javascript">
        $('.flash').delay(5000).fadeOut( "slow" );

        CKEDITOR.replace( 'entrada' );
    </script>
</body>
</html>
