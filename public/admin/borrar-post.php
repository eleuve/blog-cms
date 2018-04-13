<?php
session_start();
if (!isset($_SESSION["login"]) || $_SESSION["login"] != true) {
    header("Location: index.php", true, 302);
    die();
}

include_once '../../DB/conexion.php';


if (isset($_GET["id"])) {

    $sql = "SELECT imagen from post WHERE idpost = " . $_GET["id"];

    //ejecutamos la query
    $resultadoDelQuery = mysqli_query($con, $sql);

    $row = $resultadoDelQuery->fetch_assoc();

    unlink('../uploads/' . $row["imagen"]);

    /*if(file_exists($file)) {
    } else {
        echo "archivo no encontrado";
    }
    */

    $sql = "DELETE FROM post WHERE idpost = " . $_GET["id"];
    
    // ejecuta la sql com oya sabes
    
    // muestra mensaje: borrado

    $resultadoDelQuery = mysqli_query($con, $sql);

    $mensaje = "Post borrado correctamente.";

    $_SESSION["flash_type"] = "notificacion";

    if (mysqli_errno($con)) {
        print_r(mysqli_error($con));
        $mensaje = "Inténtelo de nuevo más tarde o contacte con el administrador";
        $_SESSION["flash_type"] = "error";
    }

    $_SESSION["flash_message"] = $mensaje;


    // Cerramos la conexion porque hemos acabado
    mysqli_close($con);

    }

    header("Location: gestionPosts.php", true, 302);
    die();

?>


