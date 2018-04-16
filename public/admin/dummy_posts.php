<?php

$totalPosts = 800;

require_once "../../DB/conexion.php";

// Preparamos la fecha para el SQL
$datetimeHoy = new \Datetime("now");
$fechaHoy = date("Y-m-d H:i:s", $datetimeHoy->getTimestamp());

// Funcion que devuelve un SQL que solo difiere el titulo
$crearSql = function($titulo) {
    $datetimeHoy = new \Datetime("now");
    $fechaHoy = date("Y-m-d H:i:s", $datetimeHoy->getTimestamp());

    // Preparamos el SQL
    $sql = sprintf(
        "INSERT INTO `post` (`idpost`, `titulo`, `entradilla`, `contenido`, `fecha`, `idcategoria`, `imagen`, `activo`, `altimagen`) VALUES (%s, '%s', '%s', '%s', '%s', '%s', '%s', %s, '%s')",
        "NULL",
        $titulo,
        'DUMMY FAKE POST',
        'DUMMY FAKE POST, DUMMY FAKE POST, DUMMY FAKE POST, DUMMY FAKE POST, DUMMY FAKE POST, DUMMY FAKE POST, DUMMY FAKE POST...',
        $fechaHoy,
        38, // fresas
        'DUMMY_FILENAME.jpg',
        true,
        "DUMMY ALT IMAGE"
    );

    return $sql;
};


for($cont = 0; $cont <= $totalPosts; $cont++) {
    $sql = $crearSql("DUMMY TITLE " . $cont);

    // Ejecutamos el SQL con la respectiva conexion ($con)
    $resultadoDelQuery = mysqli_query($con, $sql);
}

// Cerramos la conexion porque hemos acabado
mysqli_close($con);

die($totalPosts ." posts created!");
