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
<a href="gestion.php">VOLVER AL MENÚ PRINCIPAL</a><br />


<a href="crear-post.php">CREAR UN NUEVO POST</a>

<?php
// vamos a listar los posts que hay en la base de datos...

$sql = "SELECT * FROM post WHERE activo = 1";

$result = mysqli_query($con, $sql);

while ($post = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    ?>
    <div>
        <h2><?php echo $post["titulo"]; ?></h2>
        <h3><?php echo $post["entradilla"]; ?></h3>
        <?php echo $post["fecha"]; ?>
        
        <p><?php echo $post["contenido"]; ?></p>
        <a href="modificar-post.php?id=<?php echo $post["idpost"]; ?>">MODIFICAR ESTE POST</a>

        <a href="borrar-post.php?id=<?php echo $post["idpost"]; ?>" class="confirmacion">BORRAR ESTE POST</a>
        
    </div>
    <?php
}


?>

<script type="text/javascript">
    var elemento = document.getElementsByClassName('confirmacion');
    var confirmar = function (e) {
        if (!confirm('¿Seguro que quieres eliminar permanentemente el post? \n Esta acción no se puede deshacer.')) e.preventDefault();
    };
    for (var i = 0, l = elemento.length; i < l; i++) {
        elemento[i].addEventListener('click', confirmar, false);
    }
</script>

