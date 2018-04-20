
<!DOCTYPE html>
<html lang="es">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Blog - Francisco Vidal</title>

  <!-- Bootstrap core CSS -->
  <link href="css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/blog-post.css" rel="stylesheet">

</head>

<body>

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
      <a class="navbar-brand" href="index.php">CoachingAbierto</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active">
            <a class="nav-link" href="#">Home
              <span class="sr-only">(current)</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Services</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Contact</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Page Content -->
  <div class="container pt-5">

    <div class="row">

      <!-- Post Content Column -->
      <div class="col-lg-8">

       <?php

       include_once '../DB/conexion.php';


       //Evitamos inyección SQL
       $slug = mysqli_real_escape_string($con, $_GET["slug"]);

       $sql = "SELECT * FROM post WHERE activo = 1 AND slug = '" . $slug . "'";
       $resultado = mysqli_query($con, $sql);
       $post = mysqli_fetch_array($resultado, MYSQLI_ASSOC);

       if ($post === NULL) {
         header('Location: 404.php');
         die;
       }

       ?>


       <!-- Title -->
       <h1 class="mt-4"><?php echo $post["titulo"]; ?></h1>
       <h2 class="mt-4"><?php echo $post["entradilla"]; ?></h2>

       <hr>

       <?php 

       $idcategoria = $post["idcategoria"];

       $consulta = mysqli_query($con, "SELECT * FROM categoria WHERE idcategoria=" . mres($idcategoria));

       $row = $consulta->fetch_assoc();

       $fecha = strtotime($post["fecha"]);
       $formatoFecha = date("d/m/y H:i", $fecha)

       ?>

       <!-- Date/Time -->
       <p>Publicado <?php echo $formatoFecha ?> | Categoría  <a href="categoria.php?slug=<?= $row["slug"] ?>"><?php echo $row["nombre"]; ?></a></p>

       <hr>

       <!-- Preview Image -->
       <img class="img-fluid rounded imagen-entrada" src="uploads/<?php echo $post["imagen"] ?>" alt="<?php echo $post["altimagen"]?>" width="900">

       <hr>

       <!-- Post Content -->
       <?php echo $post["contenido"]; ?>

       <hr>
     </div>

     <!-- Sidebar Widgets Column -->
     <div class="col-md-4">

      <!-- Categories Widget -->
      <div class="card my-4">
        <h5 class="card-header">Categorías</h5>
        <div class="card-body">
          <div class="row">
            <div class="col-12">
              <ul class="list-unstyled mb-0">
                <?php
                      // Consultamos las categorias e iteramos sobre ellas para imprimir los <options> pertinentes.
                $resultado = mysqli_query($con, "SELECT * FROM categoria");
                while ($categoria = mysqli_fetch_array(
                  $resultado,MYSQLI_ASSOC)) {
                    ?>
                    <li><a href="categoria.php?slug=<?= $categoria["slug"] ?>"><?= $categoria["nombre"] ?></a></li>
                    <?php
                  }
                  ?>
                </ul>
              </div>
            </div>
          </div>
        </div>

        <!-- Side Widget -->
        <div class="card my-4">
          <h5 class="card-header">Últimas entradas...</h5>
          <div class="card-body">
            <?php

            $resultado = mysqli_query($con, "SELECT * FROM post WHERE NOT idpost=" . mres($post["idpost"]) . " ORDER BY fecha DESC LIMIT 5");
                while ($entradalateral = mysqli_fetch_array(
                  $resultado,MYSQLI_ASSOC)) {
                    ?>
            <div class="entrada-lateral">
              <p><strong><?=$entradalateral["titulo"]?></strong></p>
              <img src="uploads/<?=$entradalateral["imagen"]?>" alt="<?=$entradalateral["altimagen"]?>" class="img-fluid rounded" style="max-height: 200px; max-width: ">
              <p><?=$entradalateral["entradilla"]?></p>
              <hr>
            </div>
            <?php
            }
            ?>  
          </div>
        </div>

      </div>

    </div>
    <!-- /.row -->

  </div>
  <!-- /.container -->

  <!-- Footer -->
  <footer class="py-5 bg-dark">
    <div class="container">
      <p class="m-0 text-center text-white">Copyright &copy; CoachingAbierto 2018</p>
    </div>
    <!-- /.container -->
  </footer>

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>

