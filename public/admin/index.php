<?php
session_start();

if (isset($_POST["login"])) {
    $user = "laura";
    $pass = "miPass";

    if ($_POST["user"] == $user && $_POST["pass"] == $pass) {
        // Se ha hecho login de puta madre...
        $_SESSION["login"] = true;
        $_SESSION["username"] = "Francisco";
        // Redirecciona a dashboard...
        header('Location: gestion.php');
    } else {
        die('Usuario y/o pass incorrecto/s');
    }
}


?>

<style>
    form {
        width: 200px;
        height: 80px;
        border: 1px solid red;
        border-radius: 10px;
        position: absolute;
        text-align: center;
        left: 50%;
        top: 50%;
        margin-left: -100px;
        margin-top: -40px;
        padding: 10px;
    }
</style>

<form action="index.php" method="post">
    <label for="">User:</label>
    <input type="text" name="user"><br/>

    <label for="">Pass:</label>
    <input type="password" name="pass"><br/>

    <input type="submit" value="Login" name="login">
</form>