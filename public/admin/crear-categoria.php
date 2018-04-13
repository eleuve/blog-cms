<?php
session_start();
if (!isset($_SESSION["login"]) || $_SESSION["login"] != true) {
    header("Location: index.php", true, 302);
    die();
}

// Necesitamos la variable que nos facilita conexion de la base de datos: $con
require_once "../../DB/conexion.php";

// IF que solo se ejecuta si hay POST enviar (es el submit input)
if (isset($_POST["enviar"])) {
    /**
     * @todo Asegurarnos que las 6 variables siguientes son aptas, es decir, not-empty o... con valores raros o SQL code (injection...)
     */
    $nombre = $_POST["nombre"];
    $url = $_POST["url"];

    // Preparamos la fecha para el SQL
    $datetimeHoy = new \Datetime("now");
    $fechaHoy = date("Y-m-d H:i:s", $datetimeHoy->getTimestamp());

    // Preparamos el SQL
    $sql = sprintf(
        "INSERT INTO `categoria` (`idcategoria`, `nombre`, `slug`, `fecha`) VALUES (%s, '%s', '%s', '%s');",
        "NULL",
        $nombre,
        $url,
        $fechaHoy
    );

    // Ejecutamos el SQL con la respectiva conexion ($con)
    $resultadoDelQuery = mysqli_query($con, $sql);

    // la variable que esto devuelve no la necesitamos para nada  de momento pero ahi queda... servira para ver si no ha guardado el INSERT,
    // mostrar un mensaje rollo 'Intentelo de nuevo mas tarde o contacte con el administrador'

    // si hay error de cualquier tipo, mostramos un mensaje, en caso contrario mostramos otro
    $mensaje = "Categoría creada correctamente: " . $_POST["nombre"];
    if (mysqli_errno($con)) {
        print_r(mysqli_error($con));
        $mensaje = "Inténtelo de nuevo más tarde o contacte con el administrador.";
    }

    echo "<h1>" . $mensaje . "</h1>";

    // Cerramos la conexion porque hemos acabado
    mysqli_close($con);

    header("Location: gestionCategorias.php", true, 302);
    die();
}

?>

<a href="gestionCategorias.php" class="confirmacion">VOLVER AL MENÚ DE GESTIÓN</a>

<h1>Crear categoría</h1>

<form action="crear-categoria.php" method="post" enctype="multipart/form-data">

    <label for="">Nombre:</label>
    <input type="text" name="nombre" required><br/>

    <label for="">Url:</label>
    <input type="text" name="url" required><br/>

    <input type="submit" value="Enviar" name="enviar">
</form>


<script type="text/javascript">
    var elemento = document.getElementsByClassName('confirmacion');
    var confirmar = function (e) {
        if (!confirm('¿Seguro que quieres volver atrás? \n Los cambios que hayas hecho no se guardarán.')) e.preventDefault();
    };
    for (var i = 0, l = elemento.length; i < l; i++) {
        elemento[i].addEventListener('click', confirmar, false);
    }
</script>
