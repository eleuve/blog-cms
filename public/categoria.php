<!DOCTYPE html>
<html lang="es">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Blog  - Francisco Vidal</title>

  <!-- Bootstrap core CSS -->
  <link href="css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/blog-home.css" rel="stylesheet">

</head>

<body>

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
      <a class="navbar-brand" href="#">Francisco Vidal</a>
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

      <!-- Blog Entries Column -->
      <div class="col-md-8">

        <h1 class="my-4">Entradas
          <small>Secondary Text</small>
        </h1>

        <!-- Blog Post -->
        <?php

        include_once '../DB/conexion.php';



        if (isset($_GET["slug"])) {

            $slug = $_GET["slug"];

            $sql = "SELECT idcategoria FROM categoria WHERE slug='$slug'";

            $resultado = mysqli_query($con, $sql);
            $r = mysqli_fetch_object($resultado);

            $id = $r->idcategoria;

            $filtroCategoriaId = $id;
        }

        include_once 'paginacion.php';

        ?>
        <!-- Pagination -->
        <ul class="pagination justify-content-center mb-4">
          <?php
          $printPaginationLinks();
          ?>
        </ul>
        <?php

        if (isset($_GET["slug"])) {

          $sql = "SELECT * FROM post WHERE idcategoria='$id' ORDER BY fecha DESC LIMIT $offset, $postsPorPag";

          $result = mysqli_query($con, $sql);

          while ($post = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            ?>   
            <div class="card mb-4">
              <img class="card-img-top" src="uploads/<?php echo $post["imagen"] ?>" alt="<?php echo $post["altimagen"]?>">
              <div class="card-body">
                <a href="entrada.php?slug=<?= $post['slug'] ?>"><h2 class="card-title"><?php echo $post["titulo"]; ?></h2></a>
                <p class="card-text"><?php echo $post["entradilla"]; ?></p>
              </div>
              <div class="card-footer text-muted">
                Publicado <?php echo $post["fecha"]; ?>
              </div>
            </div>
            <?php
          }
        }

        ?>

        <!-- Pagination -->
        <ul class="pagination justify-content-center mb-4">
          <?php
          $printPaginationLinks();
          ?>
        </ul>

      </div>

      <!-- Sidebar Widgets Column -->
      <div class="col-md-4">

        <!-- Search Widget -->
        <div class="card my-4">
          <h5 class="card-header">Búsqueda</h5>
          <div class="card-body">
            <div class="input-group">
              <input type="text" class="form-control">
              <span class="input-group-btn">
                <button class="btn btn-secondary" type="button">Buscar</button>
              </span>
            </div>
          </div>
        </div>

        <!-- Categories Widget -->
        <div class="card my-4">
          <h5 class="card-header">Categorías</h5>
          <div class="card-body">
            <div class="row">
              <div class="col-lg-6">
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
            <h5 class="card-header">Side Widget</h5>
            <div class="card-body">
              You can put anything you want inside of these side widgets. They are easy to use, and feature the new Bootstrap 4 card containers!
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
        <p class="m-0 text-center text-white">Copyright &copy; Francisco Vidal 2018</p>
      </div>
      <!-- /.container -->
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

  </body>

  </html>
