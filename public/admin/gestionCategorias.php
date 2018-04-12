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
<hr />

<a href="crear-categoria.php">CREAR UNA NUEVA CATEGORÍA</a>

<?php

// vamos a listar las categorías que hay en la base de datos...
$sql = "SELECT * FROM categoria";

$result = mysqli_query($con, $sql);

while ($categoria = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    ?>
    <div>
        <h2><?php echo $categoria["nombre"]; ?></h2>
        <h3><?php echo $categoria["slug"]; ?></h3>
        <?php echo $categoria["fecha"]; ?>
        <a href="modificar-categoria.php?id=<?php echo $categoria["idcategoria"]; ?>">MODIFICAR CATEGORÍA</a>

        <a href="borrar-categoria.php?id=<?php echo $categoria["idcategoria"]; ?>" class="confirmacion">BORRAR CATEGORÍA</a>
        
    </div>
    <?php
}


?>

<script type="text/javascript">
    var elemento = document.getElementsByClassName('confirmacion');
    var confirmar = function (e) {
        if (!confirm('¿Seguro que quieres eliminar permanentemente la categoría? \n Esta acción no se puede deshacer.')) e.preventDefault();
    };
    for (var i = 0, l = elemento.length; i < l; i++) {
        elemento[i].addEventListener('click', confirmar, false);
    }
</script>

