<?php
session_start();

if (isset($_POST["login"])) {
    $user = "laura";
    $pass = "miPass";

    if ($_POST["user"] == $user && $_POST["pass"] == $pass) {
        // Se ha hecho login de puta madre...
        $_SESSION["login"] = true;
        // Redirecciona a dashboard...
        header('Location: dashboard.php');
    } else {
        die('Usuario y/o pass incorrecto/s');
    }
}


?>

<form action="index.php" method="post">
    <label for="">User:</label>
    <input type="text" name="user"><br/>

    <label for="">Pass:</label>
    <input type="password" name="pass"><br/>

    <input type="submit" value="Login" name="login">
</form>
