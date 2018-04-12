<?php

include_once '../../DB/conexion.php';


if (isset($_GET["id"])) {

    $sql = "SELECT * from post WHERE idpost = " . $_GET["id"];
    
    // Ejecutamos el SQL con la respectiva conexion ($con)
    $resultadoDelQuery = mysqli_query($con, $sql);

    //Metemos en variables los resultados de la consulta
    while($row = $resultadoDelQuery->fetch_assoc()) {
        $titulo = $row["titulo"];
        $entradilla = $row["entradilla"];
        $file = $row["imagen"];
        $html = $row["contenido"];
        $esPublico = $row["activo"];
        $altimagen = $row["altimagen"];
        $idcategoria = $row["idcategoria"];     
    }
    

    // IF que solo se ejecuta si hay POST editar (es el submit input)
    if (isset($_POST["editar"])) {
        /**
         * @todo Asegurarnos que las 6 variables siguientes son aptas, es decir, not-empty o... con valores raros o SQL code (injection...)
         */
        $id = $_GET["id"];
        $titulo = $_POST["titulo"];
        $entradilla = $_POST["entradilla"];
        $file = $_FILES["imagen"];
        $html = $_POST["entrada"];
        $esPublico = "false";
        $altimagen = $_POST["altimagen"];
        $idcategoria = $_POST["categoria"];


        if (isset($_POST["publico"])) {
            if ($_POST["publico"] == "público") {
             $esPublico = "true";
            }
        }

        // Si hay nuevo archivo
        if ($file["size"] > 0) {
            // 1) Borrar el anterior archivo con unlink()
            // 2) Guardar el nuevo archivo en /uploads
            // 3) Preparar el SQL que contiene el nuevo file["name"]
            $sql = sprintf(
                "UPDATE post 
             SET titulo='%s', entradilla='%s', contenido='%s', idcategoria=%s, imagen='%s', activo=%s, altimagen='%s'
             WHERE idpost=%s",
                $titulo,
                $entradilla,
                $html,
                $idcategoria,
                $file["name"],
                $esPublico,
                $altimagen,
                $_GET["id"]
            );

        } else {
            $sql = sprintf(
                "UPDATE post 
             SET titulo='%s', entradilla='%s', contenido='%s', idcategoria=%s, activo=%s, altimagen='%s'
             WHERE idpost=%s",
                $titulo,
                $entradilla,
                $html,
                $idcategoria,
                $esPublico,
                $altimagen,
                $_GET["id"]
            );
        }

        // Ejecutamos el SQL con la respectiva conexion ($con)
        $resultadoDelQuery = mysqli_query($con, $sql);

        // la variable que esto devuelve no la necesitamos para nada  de momento pero ahi queda... servira para ver si no ha guardado el INSERT,
        // mostrar un mensaje rollo 'Intentelo de nuevo mas tarde o contacte con el administrador'

        // si hay error de cualquier tipo, mostramos un mensaje, en caso contrario mostramos otro
        $mensaje = "Post modificado correctamente: " . $_POST["titulo"];
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


<h1>Editar post "<?=$titulo?>"</h1>

<form action="modificar-post.php?id=<?= $_GET["id"]; ?>" method="post" enctype="multipart/form-data">

    <label for="">Categoría</label>
    <select name="categoria">
        <option value="null">-SIN CATEGORÍA-</option>
        <?php
        // Consultamos las categorias e iteramos sobre ellas para imprimir los <options> pertinentes.
        $resultado = mysqli_query($con, "SELECT * FROM categoria");
        while ($categoria = mysqli_fetch_array(
            $resultado,
            MYSQLI_ASSOC
        )) {
            ?><option value="<?= $categoria["idcategoria"] ?>" <?= $categoria["idcategoria"]==$idcategoria ? "selected" : ""; ?>><?= $categoria["nombre"] ?></option><?php
        }
        ?>
    </select><br/>
    <label for="">Título:</label>
    <input type="text" name="titulo" value="<?=$titulo?>"><br />

    <label for="">Entradilla:</label>
    <input type="text" name="entradilla" value="<?=$entradilla?>"><br />

    <label for="">Imagen:</label>
    <input type="file" name="imagen"  value="<?=$file?>"><br />

    <label for="">Alt de la imagen:</label>
    <input type="text" name="altimagen"  value="<?=$altimagen?>"><br />

    <label for="">Entrada:</label>
    <textarea name="entrada" id="" cols="30" rows="40"> <?=$html?></textarea><br />

    <input type="checkbox" name="publico" value="público" name="publico">Público<br><br />

    <input type="submit" value="Editar post" name="editar">
</form>


