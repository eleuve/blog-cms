<?php
session_start();
if (!isset($_SESSION["login"]) || $_SESSION["login"] != true) {
    header("Location: index.php", true, 302);
    die();
}

include_once '../../DB/conexion.php';


if (isset($_GET["id"])) {

    $sql = "SELECT * from post WHERE idpost = " . $_GET["id"];
    
    // Ejecutamos el SQL con la respectiva conexion ($con)
    $resultadoDelQuery = mysqli_query($con, $sql);

    //Metemos en variables los resultados de la consulta
    while($row = $resultadoDelQuery->fetch_assoc()) {
        $titulo = $row["titulo"];
        $entradilla = $row["entradilla"];
        $file = $row["imagen"];
        $html = $row["contenido"];
        $esPublico = $row["activo"];
        $altimagen = $row["altimagen"];
        $idcategoria = $row["idcategoria"];     
    }
    
    $fileNameABorrarSiHayNuevo = $file;


    if($esPublico==1){
        $checked="checked";
    }else{
        $checked="";
    }

    // IF que solo se ejecuta si hay POST editar (es el submit input)
    if (isset($_POST["editar"])) {
        /**
         * @todo Asegurarnos que las 6 variables siguientes son aptas, es decir, not-empty o... con valores raros o SQL code (injection...)
         */
        $id = $_GET["id"];
        $titulo = $_POST["titulo"];
        $entradilla = $_POST["entradilla"];
        $file = $_FILES["imagen"];
        $html = $_POST["entrada"];
        $esPublico = "false";
        $altimagen = $_POST["altimagen"];
        $idcategoria = $_POST["categoria"];


        if (isset($_POST["publico"])) {
            if ($_POST["publico"] == "público") {
             $esPublico = "true";
            }
        }

        // Si hay nuevo archivo
        if ($file["size"] > 0) {
            // 1) Borrar el anterior archivo con unlink()
            unlink('../uploads/' . $fileNameABorrarSiHayNuevo);

            // 2) Guardar el nuevo archivo en /uploads

            /** Guardado del archivo en la carpeta /uploads */
            // El archivo se sube a una ruta temporal de PHP (a saber cual), no hay funcion MOVE en php, asi que leemos el contenido del archivo...
            $imageBinaryData = file_get_contents($file["tmp_name"]);
            // Crea el archivo en uploads, require 2 cosas: nombre de archivo, contenido
            file_put_contents('../uploads/' . $file["name"], $imageBinaryData);


            // 3) Preparar el SQL que contiene el nuevo file["name"]

            $sql = sprintf(
                "UPDATE post 
             SET titulo='%s', entradilla='%s', contenido='%s', idcategoria=%s, imagen='%s', activo=%s, altimagen='%s'
             WHERE idpost=%s",
                $titulo,
                $entradilla,
                $html,
                $idcategoria,
                $file["name"],
                $esPublico,
                $altimagen,
                $_GET["id"]
            );

        } else {
            $sql = sprintf(
                "UPDATE post 
             SET titulo='%s', entradilla='%s', contenido='%s', idcategoria=%s, activo=%s, altimagen='%s'
             WHERE idpost=%s",
                $titulo,
                $entradilla,
                $html,
                $idcategoria,
                $esPublico,
                $altimagen,
                $_GET["id"]
            );
        }

        // Ejecutamos el SQL con la respectiva conexion ($con)
        $resultadoDelQuery = mysqli_query($con, $sql);

        // la variable que esto devuelve no la necesitamos para nada  de momento pero ahi queda... servira para ver si no ha guardado el INSERT,
        // mostrar un mensaje rollo 'Intentelo de nuevo mas tarde o contacte con el administrador'

        // si hay error de cualquier tipo, mostramos un mensaje, en caso contrario mostramos otro
        $mensaje = "Post modificado correctamente: " . $_POST["titulo"];
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
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>Modificar post - Gestor</title>
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
            <div class="col-5 text-left p-3">
                <i class="fas fa-home fa-2x"></i><br />
                <a href="gestion.php">INICIO</a>
            </div>
        </div>

        <div class="row">
            <div class="col-s-12 col-md-9 mx-auto mt-4">
                <i class="fas fa-arrow-alt-circle-left pl-3"></i>
                <a href="gestionPosts.php" class="confirmacion">VOLVER A POSTS</a>
                <div id="form-container" class="container">
                    <form action="modificar-post.php?id=<?= $_GET["id"]; ?>" method="post" enctype="multipart/form-data">
                        <h2 class="text-center">Editar post "<?=$titulo?>"</h2>
                        <div class="row">
                            <div class="col-xsl-12 mx-auto">
                                <div class="form-group">
                                    <label for="">Categoría</label>
                                    <select class="form-control" name="categoria">
                                        <option value="null">-SIN CATEGORÍA-</option>
                                        <?php
                                        // Consultamos las categorias e iteramos sobre ellas para imprimir los <options> pertinentes.
                                        $resultado = mysqli_query($con, "SELECT * FROM categoria");
                                        while ($categoria = mysqli_fetch_array(
                                             $resultado,
                                             MYSQLI_ASSOC
                                        )) {
                                         ?><option value="<?= $categoria["idcategoria"] ?>" <?= $categoria["idcategoria"]==$idcategoria ? "selected" : ""; ?>><?= $categoria["nombre"] ?></option><?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Título:</label>
                                    <input class="form-control" type="text" name="titulo" value="<?=$titulo?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="">Entradilla:</label>
                                    <input class="form-control" type="text" name="entradilla" value="<?=$entradilla?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="">Imagen:</label>
                                    <input class="form-control" type="file" name="imagen"  value="<?=$file?>">
                                    <small>El tamaño recomendado es de 900x300.</small>
                                </div>
                                <div class="form-group">
                                    <label for="">Alt de la imagen:</label>
                                    <input class="form-control" type="text" name="altimagen"  value="<?=$altimagen?>">
                                    <small>Este campo ayudará a las personas que no puedan ver la imagen o usen lector de pantalla.</small>
                                </div>
                                <div class="form-group">
                                    <label for="">Entrada:</label>
                                    <textarea class="form-control" name="entrada" id="" cols="30" rows="40" required> <?=$html?></textarea>
                                </div>
                                <div class="form-group">
                                    <input type="checkbox" name="publico" value="público" <?= $checked ?>> Público<br>
                                 </div>
                                <div class="form-group">
                                    <input class="btn btn-primary" type="submit" value="Editar post" name="editar">
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


