<?php
session_start();
if (!isset($_SESSION["login"]) || $_SESSION["login"] != true) {
    header("Location: index.php", true, 302);
    die();
}

// Necesitamos la variable que nos facilita conexion de la base de datos: $con
require_once "../../DB/conexion.php";
require_once "slug.php";


// IF que solo se ejecuta si hay POST enviar 
if (isset($_POST["submit"])) {

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

    /**
     * Validación de datos del formulario
     */
    $valido = true;
    $mensajeDeError = "";

    // El título no puede estar vacío
    if ("" == $titulo) {
        $valido = false;
        $mensajeDeError = "Por favor, especifique un título.";
    }

    // El archivo subido tiene que ser una imagen
    $typeSportados = [
        "image/png",
        "image/jpg",
        "image/jpeg",
        "image/gif"
    ];
    if (! in_array($file["type"], $typeSportados)) {
        $valido = false;
        $mensajeDeError = "Archivo no soportado. Por favor, suba una imagen de tipo .jpg .jpeg .png o .gif";
    }

    // Si todos los datos introducidos son válidos...
    if ($valido) {
        /** Guardado del archivo en la carpeta /uploads */

        // El archivo se sube a una ruta temporal de PHP así que leemos la ruta
        $imageBinaryData = file_get_contents($file["tmp_name"]);

        // Creamos el archivo en uploads, require 2 cosas: nombre de archivo y contenido
        file_put_contents('../uploads/' . $file["name"], $imageBinaryData);

        // Preparamos la fecha para el SQL
        $datetimeHoy = new \Datetime("now");
        $fechaHoy = date("Y-m-d H:i:s", $datetimeHoy->getTimestamp());

        // Preparamos el SQL (mres es una función que está en conexion.php y sirve para evitar inyecciones SQL en la BD)
        $sql = sprintf(
            "INSERT INTO `post` (`idpost`, `titulo`, `entradilla`, `contenido`, `fecha`, `idcategoria`, `imagen`, `activo`, `altimagen`, `slug`) VALUES (%s, '%s', '%s', '%s', '%s', '%s', '%s', %s, '%s', '%s')",
            "NULL",
            mres($titulo),
            mres($entradilla),
            mres($html),
            mres($fechaHoy),
            mres($idCategoria),
            mres($file["name"]),
            mres($esPublico),
            mres($altimagen),
            mres(slugify($titulo))
        );

        // Ejecutamos el SQL con la respectiva conexion ($con)
        $resultadoDelQuery = mysqli_query($con, $sql);

        // Si hay error de cualquier tipo, mostramos un mensaje, en caso contrario mostramos otro
        $mensaje = "Post creado correctamente: " . $_POST["titulo"];
        if (mysqli_errno($con)) {
            print_r(mysqli_error($con));
            $mensaje = "Inténtelo de nuevo más tarde.";
        }

        echo "<h1>" . $mensaje . "</h1>";

        // Cerramos la conexión porque hemos acabado
        mysqli_close($con);

        //Cuando se haya creado un post nos lleva al menú de gestión
        header("Location: gestionPosts.php", true, 302);
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
                        <a href="logout.php" class="align-middle"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</a>
                    </div>
                </div>
            </header>
        </div>
    </div>


    <div class="container-fluid">
        <div class="row">
            <div class="col-5 text-left p-3">
                <a href="gestion.php" class="confirmacion"><i class="fas fa-home fa-2x"></i><br />INICIO</a>
            </div>
        </div>
        <div class="row">
            <div class="col-s-12 col-md-9 mx-auto mt-4">
                <a href="gestionPosts.php" class="confirmacion"><i class="fas fa-arrow-alt-circle-left pl-3"></i> VOLVER A POSTS</a>

                <div id="form-container" class="container">
                    <form action="crear-post.php" method="post" enctype="multipart/form-data">
                        <?php
                            if (isset($valido)) {
                                if ($valido === false) {
                                    ?>
                                    <div class="form-error"><?= $mensajeDeError ?></div>
                                    <?php
                                }
                            }
                        ?>
                     <h2 class="text-center">Crear post</h2>
                     <div class="row">
                        <div class="col-xsl-12 mx-auto">
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
                                <input class="form-control" type="text" name="titulo" id="titulo" required>
                            </div>
                            <div class="form-group">
                                <label for="entradilla">Entradilla</label>
                                <input class="form-control" type="text" name="entradilla" id="entradilla" required>
                            </div>
                            <div class="form-group">
                                <label for="imagen">Imagen</label>
                                <input class="form-control" type="file" name="imagen" id="imagen" required/>
                                <small>El tamaño recomendado es de 900x300px.</small>
                            </div>
                            <div class="form-group">
                                <label for="altimagen">Alt de la imagen</label>
                                <input class="form-control" type="text" name="altimagen" id="altimagen"/>
                                <small>Este campo ayudará a las personas que no puedan ver la imagen o usen lector de pantalla.</small>

                            </div>
                            <div class="form-group">
                                <label for="entrada">Entrada</label>
                                <textarea class="form-control" name="entrada" id="entrada" required>                   
                                </textarea>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" name="publico" value="público"> Público<br>
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
    //Esto nos pide confirmación si le damos a volver atrás sin terminar de crear el post

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
