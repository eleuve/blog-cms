<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>Modificar categoría - Gestor</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">


    <?php
    session_start();

    if (isset($_POST["login"])) {
        $user = "laura";
        $pass = "miPass";


        if ($_POST["user"] == $user && $_POST["pass"] == $pass) {
            // El login es correcto
            $_SESSION["login"] = true;
            $_SESSION["username"] = "Francisco";

            // Redirecciona a gestion...
            header('Location: gestion.php');
        } else {
            die('Usuario y/o contraseña incorrecto/s');
        }
    }


    ?>

</head>
<body>
    <div class="container-fluid">
        <h1 class="text-center">Gestor de contenidos del blog</h1>
        <div class="row">
            <div class="col-4 mx-auto">
                <form action="index.php" method="post">
                    <div class="form-group">
                        <label for="usuario">Usuario</label>
                        <input type="text" class="form-control" id="usuario" name="user">
                    </div>
                    <div class="form-group">
                        <label for="contra">Contraseña</label>
                        <input type="password" class="form-control" id="contra" name="pass">
                    </div>
                    <button type="submit" class="btn btn-primary float-right" name="login">Enviar</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        
    </script>
</body>
</html>




