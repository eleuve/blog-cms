<?php

include_once '../DB/conexion.php';


// vamos a listar los posts que hay en la base de datos...

$sql = "SELECT * FROM post WHERE activo = 1";

$result = mysqli_query($con, $sql);

while ($post = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    ?>
    <div>
        <h2><?php echo $post["titulo"]; ?></h2>
        <h3><?php echo $post["entradilla"]; ?></h3>
        <?php echo $post["fecha"]; ?>
        
        <img src="uploads/<?php echo $post["imagen"] ?>" width="200">

        <p><?php echo $post["contenido"]; ?></p>
        
    </div>
    <?php
}


?>
