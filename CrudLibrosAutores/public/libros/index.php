<?php

use Src\Libros;

session_start();

require __DIR__ ."/../../vendor/autoload.php";

Libros::crearLibros(200);

$libros = Libros::readAll();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Libros</title>
    <!--FontAwesonme-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!--BootStrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <!--SweeAlert2-->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <style>
        * {
            color: white
        }
    </style>
</head>

<body style="background-color: #F0544F;">
    <h5 class="mt-4 text-center"><b>Listado de libros</b></h5>
    <div class="container">
        <a href="crear.php" class="btn btn-primary"><i class="fa-solid fa-book-bookmark"></i> Crear</a>
        <table class="table table-striped">
            <a href="./../autores/index.php" class="my-2 btn btn-success">
                <i class="fas fa-paper-plane"> </i>
                Ir a autores</a>
            <thead>
                <tr>
                    <th scope="col">Info</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Isbn</th>
                    <th scope="col">Categoria</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($libros as $libro) {
                    $lib = serialize($libro);
                    echo <<<TXT
                            <tr>
                                <th scope="row">
                                    <a href="detalles.php?id={$libro->id}" class='btn btn-sm btn-info'>
                                        <i class="fas fa-info"></i>
                                    </a>
                                </th>
                                <td>{$libro->nombre}</td>
                                <td>{$libro->isbn}</td>
                                <td>{$libro->categoria}</td>
                                <td>
                                <form method="POST" action="borrar.php" class="form-inline">
                                <input type="hidden" name="libro" value='{$lib}'/>
                                <a href="update.php?id={$libro->id}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                                </a>
                                <button type="submit" name="btn"  class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                </button>
                                </form>
                            </td>
                            </tr>
                        TXT;
                }
                ?>
            </tbody>
        </table>
    </div>
    </script>
    <?php
    if (isset($_SESSION['mensaje'])) {
        echo <<<TXT
            <script>
            Swal.fire({
                icon: 'success',
                title: '{$_SESSION['mensaje']}',
                showConfirmButton: false,
                timer: 1500
            })
            </script>
            TXT;
        unset($_SESSION['mensaje']);
    }
    ?>
</body>

</html>