<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>Gestor de posts</title>
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
                        <a href="logout.php" class="align-middle"><i class="fas fa-sign-out-alt"></i> Cerrar sesion</a>
                    </div>
                </div>
            </header>
        </div>
    </div>
  
    <div class="container-fluid">
        <div class="row">
            <div class="col-5 text-left p-3">
                <a href="gestion.php"><i class="fas fa-home fa-2x"></i><br />INICIO</a>
            </div>
        </div>
        <div class="row">
            <div class="col-s-12 col-md-9 mx-auto my-4 text-center">
                <h2>Gestión de posts</h2>
                <a href="crear-post.php" class="btn btn-primary text-center my-3" role="button">CREAR NUEVO POST</a>
                <?php

                // vamos a listar los posts que hay en la base de datos...
                $sql = "SELECT * FROM post ORDER BY fecha DESC";

                $result = mysqli_query($con, $sql);

                while ($post = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

                    $esPublico = $post["activo"];

                    if($esPublico==1){
                        $activo="";
                    }else{
                        $activo="elemento-inactivo";
                    }

                    ?>
                    <div class="row elemento <?= $activo ?>">
                        <div class="col-9 text-left">
                            <span class="fecha"><?php echo $post["fecha"]; ?></span>
                            <p><strong><?php echo $post["titulo"]; ?></strong><br/>
                            <?php echo $post["entradilla"]; ?><br/>
                            <span class="contenido-reducido"><?php echo substr($post["contenido"], 0, 200); ?></span></p>
                        </div>
                        <div class="col-3">
                            <div class="row">
                                <div class="col-6 mt-2">
                                    <a href="modificar-post.php?id=<?php echo $post["idpost"]; ?>" class="btn-modificar btn btn-primary btn-block" role="button"><i class="far fa-edit fa-2x"></i><br />Modificar</a>
                                </div>
                                <div class="col-6 mt-2">
                                    <a href="borrar-post.php?id=<?php echo $post["idpost"]; ?>" class="confirmacion btn-borrar btn btn-primary btn-block " role="button"><i class="far fa-trash-alt fa-2x"></i><br />Eliminar</a>
                                </div>
                            </div>
                        </div>       
                    </div>
                    <?php
                }


                ?>

            </div>
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