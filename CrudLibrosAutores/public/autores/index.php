<?php
session_start();

use Src\Autores;
use Src\Libros;

require __DIR__."/../../vendor/autoload.php";

(new Autores)->crearAutor(50);

$autores = Autores::readAll();

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autores</title>
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
    <h5 class="text-center mt-4 fw-bold">Listado Autores</h5>
    <div class="container">
        <a href="crear.php" class="my-2 btn btn-primary">
            <i class="fas fa-add"> </i>
            Crear
        </a>
        <a href="./../libros/index.php" class="my-2 btn btn-success">
            <i class="fas fa-paper-plane"> </i>
            Ir a libros
        </a>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">NOMBRE</th>
                    <th scope="col">IMAGEN</th>
                    <th scope="col">FECHA DE NACIMIENTO</th>
                    <th scope="col">ACCIONES</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($autores as $autor) {
                    $aut = serialize($autor);
                    echo <<<TXT
                        <tr>
                            <th scope="row">{$autor->id}</th>
                            <td>{$autor->nombre}</td>
                            <td><img src="./../{$autor->foto}" class="img-thumbnail" style="width:5rem; height:5rem;"/></td>
                            <td>{$autor->fecha_nacimiento}</td>
                            <td>
                                <form class="form form-inline" action="borrar.php" method="POST">
                                    <input type="hidden" name="autor" value='{$aut}'/>
                                    <a href="update.php?id=$autor->id" class="btn btn-warning">
                                    <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="submit" class="btn btn-danger">
                                    <i class="fa-solid fa-trash-can"></i>
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