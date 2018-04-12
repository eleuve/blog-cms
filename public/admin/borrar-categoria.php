<?php
session_start();
if (!isset($_SESSION["login"]) || $_SESSION["login"] != true) {
    header("Location: index.php", true, 302);
    die();
}

include_once '../../DB/conexion.php';


if (isset($_GET["id"])) {

    $sql = "DELETE FROM categoria WHERE idcategoria = " . $_GET["id"];

    $resultadoDelQuery = mysqli_query($con, $sql);

    $mensaje = "Categoría borrada correctamente.";

    if (mysqli_errno($con)) {
        print_r(mysqli_error($con));
        $mensaje = "Inténtelo de nuevo más tarde o contacte con el administrador.";
    }

    echo "<h1>" . $mensaje . "</h1>";

    // Cerramos la conexion porque hemos acabado
    mysqli_close($con);

    }

?>

<a href="gestionCategorias.php">VOLVER A GESTIÓN DE CATEGORÍAS</a><br />



