<?php
session_start();
if (!isset($_SESSION["login"]) || $_SESSION["login"] != true) {
    header("Location: index.php", true, 301);
    die();
}

include_once '../../DB/conexion.php';

?>

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

        <a href="borrar-post.php?id=<?php echo $post["idpost"]; ?>">BORRAR ESTE POST</a>
        
    </div>
    <?php
}


?>
