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

    <div class="row">
        <div class="col-s-12 col-md-9 mx-auto mt-4 text-center" style="background-color: pink;">
            <h2>Gestión de posts</h2>
            <a href="crear-post.php" class="btn btn-primary text-center my-3" role="button">CREAR NUEVO POST</a>
            <?php

            // vamos a listar los posts que hay en la base de datos...
            $sql = "SELECT * FROM post";

            $result = mysqli_query($con, $sql);

            while ($post = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                ?>
                <div class="row elemento">
                    <div class="col-9 text-left">
                        <h2><?php echo $post["titulo"]; ?></h2>
                        <h3><?php echo $post["entradilla"]; ?></h3>
                        <?php echo $post["fecha"]; ?>
                        <p><?php echo $post["contenido"]; ?></p>
                    </div>
                    <div class="col-3">
                        <div class="row">
                            <a href="modificar-post.php?id=<?php echo $post["idpost"]; ?>" class="col-6">MODIFICAR ESTE POST</a>

                            <a href="borrar-post.php?id=<?php echo $post["idpost"]; ?>" class="confirmacion col-6">BORRAR ESTE POST</a>
                        </div>
                    </div>       
                </div>
                <?php
            }


            ?>

        </div>
    </div>
</div>
<script src="../js/jquery-3.3.1.min.js"></script>

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