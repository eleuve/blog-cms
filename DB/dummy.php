<?php
/**
 * Vale, aqui algo de dummy content
 * insertemos posts iguales por titulo...
 */

include_once "conexion.php";

$titulos = [
    "Post primero",
    "Segundo post",
    "Otro post...",
    "mas",
    "posts",
    "que",
    "esto",
    "va",
    "a",
    "crear!!"
];

$datetimeHoy = new \Datetime("now");
$fechaHoy = date("Y-m-d H:i:s", $datetimeHoy->getTimestamp());

foreach($titulos as $titulo) {
    $sql = sprintf(
        "INSERT INTO `post` (`idpost`, `titulo`, `entradilla`, `contenido`, `fecha`, `categoria`, `imagen`, `activo`) VALUES (%s, '%s', '%s', '%s', '%s', '%s', '%s', %s)",
        "NULL",
        $titulo,
        "Entradilla...",
        "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s",
        $fechaHoy,
        "Categoria..",
        "imagen.png",
        "false"
    );

//    die($sql);

    $resultadoDelQuery = mysqli_query($con, $sql);
}

die('Dummy content created...');
