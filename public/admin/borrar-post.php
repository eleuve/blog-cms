<?php

include_once '../../DB/conexion.php';


if (isset($_GET["id"])) {
    $sql = "DELETE * FROM post WHERE id = " . $_GET["id"];
    
    // ejecuta la sql com oya sabes
    
    // muestra mensaje: borrado

    $resultadoDelQuery = mysqli_query($con, $sql);

    $mensaje = "Post borrado correctamente.";

    if (mysqli_errno($con)) {
        $mensaje = "Intentelo de nuevo mas tarde o contacte con el administrador";
    }

    echo "<h1>" . $mensaje . "</h1>";

    // Cerramos la conexion porque hemos acabado
    mysqli_close($con);

    }

?>


