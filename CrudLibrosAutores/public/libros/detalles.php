<?php

use Src\Libros;

if (!isset($_GET['id'])) {
    header("Location:index.php");
    die();
}

require __DIR__ . "/../../vendor/autoload.php";

$id = $_GET['id'];

if (!$detalle = Libros::readDetalle($id)) {
    header("Location:index.php");
    die();
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles</title>
    <!--FontAwesonme-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!--BootStrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <!--SweeAlert2-->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</head>

<body style="background-color: #F0544F;">
    <h5 class="mt-2 my-4 text-center"><b>Detalles</b></h5>
    <div class="card mx-auto" style="width: 28rem;">
        <img src="<?php echo "./../" . $detalle->portada ?>" class="card-img-top" alt="...">
        <div class="card-body">
            <h5 class="card-title fw-bold"><?php echo $detalle->nombre ?></h5>
            <p class="card-text">Categoría: <?php echo $detalle->categoria ?></p>
            <p class="card-text">ISBN: <?php echo $detalle->isbn ?></p>
            <p class="card-text">Descripcion: <?php echo $detalle->descripcion ?></p>
            <div class="mt-3 my-3 text-center">
                
                    <img src="<?php echo './../' . $detalle->foto ?>" class='my-3 img-thumbnail' class="img-thumbnail" style="width:8rem; height:8rem;">
            
            </div>
            <a href="update.php?id=<?php echo $id ?>" class="btn btn-success"><i class="fas fa-edit"></i> Editar</a>
            <a href="index.php" class="btn btn-primary"><i class="fas fa-backward"></i> Volver</a>
        </div>
    </div>
</body>

</html>