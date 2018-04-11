<?php
// IF que solo se ejecuta si hay POST enviar (es el submit input)
if (isset($_POST["enviar"])) {
    // guardamos el archivo que sube en la carpeta /uploads
    $file = $_FILES["imagen"];

    // El archivo se sube a una ruta temporal de PHP (a saber cual), no hay funcion MOVE en php, asi que leemos el contenido del archivo...
    $imageBinaryData = file_get_contents($file["tmp_name"]);

    // Crea el archivo en uploads, require 2 cosas: nombre de archivo, contenido
    file_put_contents('../uploads/' . $file["name"], $imageBinaryData);

    echo "<h1>Ok, echa un vistazo en la carpeta /uploads/ a ver si esta el archivo:" . $file["name"] . "</h1>";
}

?>

<form action="crear-post.php" method="post" enctype="multipart/form-data">
	<label for="">Título:</label>
	<input type="text" name="titulo">

	<label for="">Entradilla:</label>
	<input type="text" name="entradilla">

	<label for="">Imagen:</label>
	<input type="file" name="imagen" />

	<label for="">Entrada:</label>
	<textarea name="entrada" id="" cols="30" rows="40"></textarea>

	<input type="checkbox" name="publico" value="público" name="publico">Público<br>

	<input type="submit" value="Enviar" name="enviar">
</form>
