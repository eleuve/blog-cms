<?php
session_start();
if (!isset($_SESSION["login"]) || $_SESSION["login"] != true) {
    header("Location: index.php", true, 302);
    die();
}

include_once '../../DB/conexion.php';


if (isset($_GET["id"])) {

    $sql = "SELECT * from categoria WHERE idcategoria = " . $_GET["id"];
    
    // Ejecutamos el SQL con la respectiva conexion ($con)
    $resultadoDelQuery = mysqli_query($con, $sql);

    //Metemos en variables los resultados de la consulta
    while($row = $resultadoDelQuery->fetch_assoc()) {
        $nombre = $row["nombre"];
        $url = $row["slug"];
    }
    

    // IF que solo se ejecuta si hay POST modificar (es el submit input)
    if (isset($_POST["modificar"])) {
        /**
         * @todo Asegurarnos que las 6 variables siguientes son aptas, es decir, not-empty o... con valores raros o SQL code (injection...)
         */
        $id = $_GET["id"];
        $nombre = $_POST["nombre"];
        $url = $_POST["url"];
    
        $sql = sprintf(
            "UPDATE categoria 
            SET nombre='%s', slug='%s'
            WHERE idcategoria=%s",
                $nombre,
                $url,
                $_GET["id"]
        );

        // Ejecutamos el SQL con la respectiva conexion ($con)
        $resultadoDelQuery = mysqli_query($con, $sql);


        // si hay error de cualquier tipo, mostramos un mensaje, en caso contrario mostramos otro
        $mensaje = "Categoría modificada correctamente: " . $_POST["nombre"];
        if (mysqli_errno($con)) {
            print_r(mysqli_error($con));
            $mensaje = "Inténtelo de nuevo más tarde o contacte con el administrador.";
        }

        echo "<h1>" . $mensaje . "</h1>";

        // Cerramos la conexion porque hemos acabado
        mysqli_close($con);
    }

}

?>

<a href="gestionCategorias.php" class="confirmacion">VOLVER AL MENÚ DE GESTIÓN</a>

<h1>Editar categoría "<?=$nombre?>"</h1>

<form action="modificar-categoria.php?id=<?= $_GET["id"]; ?>" method="post" enctype="multipart/form-data">

    <label for="">Nombre:</label>
    <input type="text" name="nombre" value="<?=$nombre?>"><br />

    <label for="">URL:</label>
    <input type="text" name="url" value="<?=$url?>"><br />

    <input type="submit" value="Modificar categoria" name="modificar">
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
