<?php

include_once '../../DB/conexion.php';


if (isset($_GET["id"])) {
    $sql = "SELECT imagen from post WHERE idpost = " . $_GET["id"];

    //ejecutamos la query
    $resultadoDelQuery = mysqli_query($con, $sql);

    while($row = $resultadoDelQuery->fetch_assoc()) {
      echo $row["imagen"];
    }

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

    if (mysqli_errno($con)) {
        print_r(mysqli_error($con));
        $mensaje = "Inténtelo de nuevo más tarde o contacte con el administrador";
    }

    echo "<h1>" . $mensaje . "</h1>";

    // Cerramos la conexion porque hemos acabado
    mysqli_close($con);

    }

?>


