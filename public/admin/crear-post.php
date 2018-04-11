<?php
// IF que solo se ejecuta si hay POST titulo
if (isset($_POST["enviar"])) {
    echo "<h1>Hay que crear un post con titulo: " . $_POST["titulo"] . "</h1>";
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
