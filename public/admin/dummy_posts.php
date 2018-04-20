<?php

$totalPosts = 400;

require_once "../../DB/conexion.php";
require_once "slug.php";
// Preparamos la fecha para el SQL
$datetimeHoy = new \Datetime("now");
$fechaHoy = date("Y-m-d H:i:s", $datetimeHoy->getTimestamp());

// Función que devuelve un SQL que solo cambia el título
$crearSql = function($titulo) {
    $datetimeHoy = new \Datetime("now");
    $fechaHoy = date("Y-m-d H:i:s", $datetimeHoy->getTimestamp());

    // Preparamos el SQL
    $sql = sprintf(
        "INSERT INTO `post` (`idpost`, `titulo`, `entradilla`, `contenido`, `fecha`, `idcategoria`, `imagen`, `activo`, `altimagen`, `slug`) VALUES (%s, '%s', '%s', '%s', '%s', '%s', '%s', %s, '%s', '%s')",
        "NULL",
        $titulo,
        'DUMMY FAKE POST',
        'DUMMY FAKE POST, DUMMY FAKE POST, DUMMY FAKE POST, DUMMY FAKE POST, DUMMY FAKE POST, DUMMY FAKE POST, DUMMY FAKE POST...',
        $fechaHoy,
        38, // categoría fresas
        'DUMMY_FILENAME.jpg',
        true,
        "DUMMY ALT IMAGE",
        slugify($titulo)
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

die($totalPosts ." Posts creados.");
