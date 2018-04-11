<?php

include_once '../DB/conexion.php';

// Check connection
if (mysqli_connect_errno())
{
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}


print_r($con);



?>
