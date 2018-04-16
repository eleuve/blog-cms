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
    include_once 'slug.php';

    if (isset($_GET["id"])) {

        $sql = "SELECT * from categoria WHERE idcategoria = " . $_GET["id"];

        // Ejecutamos el SQL con la respectiva conexion ($con)
        $resultadoDelQuery = mysqli_query($con, $sql);

        //Metemos en variables los resultados de la consulta
        while($row = $resultadoDelQuery->fetch_assoc()) {
            $nombre = $row["nombre"];
        }


        // IF que solo se ejecuta si hay POST modificar (es el submit input)
        if (isset($_POST["modificar"])) {
            /**
             * @todo Asegurarnos que las 6 variables siguientes son aptas, es decir, not-empty o... con valores raros o SQL code (injection...)
             */
            $id = $_GET["id"];
            $nombre = $_POST["nombre"];
            $url = slugify($nombre);

            $sql = sprintf(
                "UPDATE categoria 
                SET nombre='%s', slug='%s'
                WHERE idcategoria=%s",
                $nombre,
                $url,
                $_GET["id"]
            );

            // Ejecutamos el SQL con la respectiva conexion ($con)
            $resultadoDelQuery = mysqli_query($con, $sql);


            // Se muestran mensajes si ha ido bien o si ha habido algún error
            $mensaje = "Categoría modificada correctamente: " . $_POST["nombre"];
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

    }
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
                <a href="gestionCategorias.php" class="confirmacion">VOLVER A CATEGORÍAS</a>

                <div id="form-container" class="container">
                    <form action="modificar-categoria.php?id=<?= $_GET["id"]; ?>" method="post" enctype="multipart/form-data">
                        <h2 class="text-center">Editar categoría "<?=$nombre?>"</h2>
                        <div class="row">
                            <div class="col-xsl-12 mx-auto">
                                <div class="form-group">
                                    <label for="nombre">Nombre:</label>
                                    <input class="form-control" type="text" name="nombre" value="<?=$nombre?>" id="nombre" required>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary" type="submit" name="modificar">Modificar</button>
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

</body>
</html>



