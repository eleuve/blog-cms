<?php

include_once '../DB/conexion.php';

$sql = "SELECT COUNT(*) FROM post";

$resultado = mysqli_query($con, $sql);
$r = mysqli_fetch_row($resultado);

          //hay que contar el número de posts que tenemos en total
$numeroPosts = $r[0];

          //solo queremos 
$postsPorPag = 10;

//está función redondea hacia arriba. si hay 10 posts por páginas y tenemos 54, en la última pag habrá únicamente 4 posts. Ceil redondea hacia arriba
$paginas = ceil($numeroPosts / $postsPorPag);

if (isset($_GET['paginaActual']) && is_numeric($_GET['paginaActual'])) {
     // cast var as int
    $paginaActual= (int) $_GET['paginaActual'];
} else {
    $paginaActual = 1;
} 

// si la página actual es mayor que el total de páginas
if ($paginaActual > $paginas) {
    // la página actual será la última página
    $paginaActual = $paginas;
} 

// si la página actual es menor que el total de páginas
if ($paginaActual < 1) {
    // la página actual será la última página
    $paginaActual = 1;
} 

$offset = ($paginaActual - 1) * $postsPorPag;
