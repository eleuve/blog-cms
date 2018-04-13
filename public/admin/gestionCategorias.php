<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>Modificar categoría - Gestor</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/fontawesome-all.css">
    <link rel="stylesheet" href="../css/style.css">

    <?php
    session_start();
    if (!isset($_SESSION["login"]) || $_SESSION["login"] != true) {
        header("Location: index.php", true, 302);
        die();
    }



    include_once '../../DB/conexion.php';

    print_r($_SESSION); 

    ?>



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
        <div style="font-size:3em; color:Tomato">
            <i class="fas fa-camera-retro"></i>
        </div>

        <a href="gestion.php">VOLVER AL MENÚ PRINCIPAL</a><br />

        <div class="row">
            <div class="col-s-12 col-md-9 mx-auto mt-4 text-center" style="background-color: pink;">
                <h2>Gestión de categorías</h2>
                <a href="crear-categoria.php" class="btn btn-primary text-center my-3" role="button">CREAR UNA NUEVA CATEGORÍA</a>

                <?php

                if(isset($_SESSION["flash_message"])) {
                    echo '<div class="flash ' . $_SESSION["flash_type"] . '">' . $_SESSION["flash_message"] . '</div>';
                    unset($_SESSION["flash_type"]);
                    unset($_SESSION["flash_message"]);
                }

                

                // vamos a listar las categorías que hay en la base de datos...
                $sql = "SELECT * FROM categoria";

                $result = mysqli_query($con, $sql);

                while ($categoria = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                ?>
                    <div class="row elemento">
                        <div class="col-9 text-left">
                            <p>Nombre: <?php echo $categoria["nombre"]; ?></p>
                            <p>Enlace: <?php echo $categoria["slug"]; ?></p>
                            <p>Creada el: <?php echo $categoria["fecha"]; ?></p>
                        </div>
                        <div class="col-3">
                            <div class="row">
                                <a href="modificar-categoria.php?id=<?php echo $categoria["idcategoria"]; ?>" class="col-6">MODIFICAR CATEGORÍA</a>

                                <a href="borrar-categoria.php?id=<?php echo $categoria["idcategoria"]; ?>" class="confirmacion col-6">BORRAR CATEGORÍA</a>
                            </div>
                        </div>
                    </div>
                    <?php
                }


                ?>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        var elemento = document.getElementsByClassName('confirmacion');
        var confirmar = function (e) {
            if (!confirm('¿Seguro que quieres eliminar permanentemente la categoría? \n Esta acción no se puede deshacer.')) e.preventDefault();
        };
        for (var i = 0, l = elemento.length; i < l; i++) {
            elemento[i].addEventListener('click', confirmar, false);
        }


    </script>
    <script type="text/javascript">
        $('.flash').delay(5000).fadeOut( "slow" );
    </script>
</body>
</html>



