<?php
$con = mysqli_connect("82.13.131.17","root","soycarlos","francisco-db");


//Esta función nos ayuda a evitar inyecciones SQL cuando metamos datos en la BD
function mres($valor) {
	$con = mysqli_connect("82.13.131.17","root","soycarlos","francisco-db");
	return mysqli_real_escape_string($con, $valor);
}
