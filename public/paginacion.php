<?php

include_once '../DB/conexion.php';

$sql = "SELECT COUNT(*) FROM post";

if (isset($filtroCategoriaId)) {
    $sql .= " WHERE idcategoria = '" . $filtroCategoriaId . "'";
}

$resultado = mysqli_query($con, $sql);
$r = mysqli_fetch_row($resultado);

          //hay que contar el número de posts que tenemos en total
$numeroPosts = $r[0];

          //solo queremos 
$postsPorPag = 10;

//está función redondea hacia arriba. si hay 10 posts por páginas y tenemos 54, en la última pag habrá únicamente 4 posts. Ceil redondea hacia arriba
$paginas = ceil($numeroPosts / $postsPorPag);

if (isset($_GET['pagina']) && is_numeric($_GET['pagina'])) {
     // cast var as int
    $paginaActual = (int) $_GET['pagina'];

    if ($paginaActual > $paginas) {
        die('Pagina no existe!');
    }
} else {
    $paginaActual = 1;
} 

// si la página actual es mayor que el total de páginas
if ($paginaActual > $paginas) {
    // la página actual será la última página
    $paginaActual = $paginas;
} 

// si la página actual es menor que el total de páginas
if ($paginaActual < 1) {
    // la página actual será la última página
    $paginaActual = 1;
} 

$offset = ($paginaActual - 1) * $postsPorPag;

$printPaginationLinks = function() use ($paginas) {
    for ($cont = 1; $cont <= $paginas; $cont++) {
        ?>
        <li class="page-item ">
            <a class="page-link" href="index.php?pagina=<?= $cont ?>"><?= $cont ?></a>
        </li>
        <?php
    }
};

/**
 * hace falta... mostrar siempre no mas de 9 botones
 * asi que si estamos en la pagina 15... mostrara el 15 en el centro y a cada lado 3 paginas, osea a la izquierda 12, 13, 14 y a la derecha 16, 17, 18
 * y como boton de la izquierda del todo, antes del 12... un  Primera pagina, y despues del 18 a la derecha un... Ultima pagina
 * [first] [12] [13] [14] [ 15 ] [16] [17] [18] [last]
 */


$printPaginationLinks = function() use ($paginas, $paginaActual) {
    // Si no estamos en la pagina UNO, se mostrara Primera pagina, si estamos, se muestra pero como activa
    if ($paginaActual !== 1) {
        ?>
        <li class="page-item ">
            <a class="page-link" href="index.php?pagina=1">1</a>
        </li>
        <?php
        if ($paginaActual > 5) {
            ?>
            <li class="page-item ">...</li>
            <?php
        }
    } else {
        ?>
        <li class="page-item active">
            <div class="page-link">1</div>
        </li>
        <?php
    }

    // 3 anteriores
    for ($cont = $paginaActual - 3; $cont < $paginaActual; $cont++) {
        if ($cont > 1) {
            ?>
            <li class="page-item ">
                <a class="page-link" href="index.php?pagina=<?= $cont ?>"><?= $cont ?></a>
            </li>
            <?php
        }
    }

    // Current page
    if ($paginaActual !== 1 && $paginaActual !== $paginas) {
        ?>
        <li class="page-item active">
            <div class="page-link disabled"><?= $paginaActual ?></div>
        </li>
        <?php
    }

    // 3 posteriores
    for ($cont = $paginaActual + 1; $cont < $paginaActual + 4; $cont++) {
        if ($cont < $paginas) {
            ?>
            <li class="page-item ">
                <a class="page-link" href="index.php?pagina=<?= $cont ?>"><?= $cont ?></a>
            </li>
            <?php
        }
    }

    // Si no estamos en la pagina ULTIMA, se mostrara Ultima pagina, si estamos, se muestra pero como activa
    if ($paginaActual < $paginas) {
        if ($paginaActual < $paginas-4) {
            ?>
            <li class="page-item ">...</li>
            <?php
        }
        ?>
        <li class="page-item">
            <a class="page-link" href="index.php?pagina=<?= $paginas ?>"><?= $paginas ?></a>
        </li>
        <?php
    }
};
