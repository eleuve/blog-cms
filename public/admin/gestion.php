<?php
session_start();
if (!isset($_SESSION["login"]) || $_SESSION["login"] != true) {
    header("Location: index.php", true, 302);
    die();
}

include_once '../../DB/conexion.php';

?>

<h1>Bienvenido, <?= $_SESSION["username"] ?></h1>
<a href="logout.php">Cerrar sesion</a>
<br /><br /><br />


<a href="gestionPosts.php">Gestionar posts</a><br />
<a href="gestionCategorias.php">Gestionar categorías</a>