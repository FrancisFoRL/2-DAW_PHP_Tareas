<?php

session_start();

require __DIR__ . "/../../vendor/autoload.php";

use Src\Autores;
use Src\Tools;

if(!isset($_GET['id'])){
    header('Location:index.php');
    die();
}

if(!Autores::existeId($_GET["id"])){
    header("Location:index.php");
    die();
}

$id = $_GET['id'];
$autor = (new Autores)->setId($id)->read();

function mostrarError($nombre)
{
    if (isset($_SESSION[$nombre])) {
        echo "<p class='text-danger'>***{$_SESSION[$nombre]}</p>";
        unset($_SESSION[$nombre]);
    }
}

if (isset($_POST['btn'])) {
    $error = false;
    $nombre = trim(ucwords($_POST['nombre']));
    $apellidos = trim($_POST['apellidos']);
    $fecha_nacimiento = new DateTime(trim($_POST['fecha']));
    if (strlen($nombre) <= 0) {
        $error = true;
        $_SESSION['nombre'] = "*** Este campo no puede estar vacio";
    }

    if (strlen($apellidos) <= 0) {
        $error = true;
        $_SESSION['apellidos'] = "*** Este campo no puede estar vacio";
    }

    if ($fecha_nacimiento->format('Y') > 2020 || $fecha_nacimiento->format('Y') < 1500) {
        $error = true;
        $_SESSION['fecha'] = "*** La fecha no es valida";
    }

    if ($error == true) {
        header("Location:{$_SERVER['PHP_SELF']}?id=$id");
        die();
    }

    $nombreImagen = $autor->foto;
    if ($_FILES['logo']['error'] == 0) {
        $images = Tools::getImages();
        if (!in_array($_FILES['logo']['type'], $images)) {
            $_SESSION['imagen'] = "*** Error, se esperaba una imagen";
            header("Location:{$_SERVER['PHP_SELF']}?id=$id");
        }
        $nombreImagen = "/img/autores/" . uniqid() ."_autor_logo.png"; //!"_{$_FILES['logo']['name']}";
        if (!move_uploaded_file($_FILES['logo']['tmp_name'], "./.." . $nombreImagen)) {
            $nombreImagen = "/img/autores/default.png";
        }else{
            if(basename($autor->foto) != "default.png"){
                unlink("./../.".$autor->foto);
            }
        }
    }
    (new Autores)
        ->setNombre($nombre)
        ->setApellidos($apellidos)
        ->setFecha_nacimiento($fecha_nacimiento->format("Y-m-d"))
        ->setFoto($nombreImagen)
        ->update($id);
    $_SESSION['mensaje'] = "*** Se ha editado el autor";
    header("Location:index.php");
} else {
?>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Editar Autor</title>
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
        <h5 class="text-center mt-4 fw-bold">Editar Autor</h5>
        <div class="container">
            <form action="<?php echo $_SERVER['PHP_SELF']."?id=$id" ?>" method="POST" class="py-4 px-4 mx-auto text-light bg-dark rounded" style="width: 40rem; height: 33rem;" enctype="multipart/form-data">
                <div class="row mt-4">
                    <div class="col">
                        <input type="text" class="form-control" id="n" placeholder="Nombre" name="nombre" value="<?php echo $autor->nombre ?>" required>
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" id="a" placeholder="Apellidos" name="apellidos" value="<?php echo $autor->apellidos ?>" required>
                    </div>
                </div>
                <div class="mb-4 my-4">
                    <input type="date" class="form-control" id="calendar" name="fecha" value="<?php echo $autor->fecha_nacimiento ?>" max="2019/01/01" max="1500/01/01" required>
                </div>
                <?php
                mostrarError("fecha");
                ?>
                <div class="mb-4 my-4">
                    <label for="n">Logo Autores</label>
                    <div class="input-group">
                        <div class="input-group">
                            <input type="file" class="form-control" id="file" name="logo">
                        </div>
                        <?php
                        mostrarError("imagen");
                        ?>
                    </div>
                </div>
                <div class="mb-4 text-center">
                    <img class="img-thumbnail" src="<?php echo "./../".$autor->foto ?>" id="image" style="width: 10rem; height: 10rem;">
                </div>
                <div class="my-4">
                    <a href="index.php" class="btn btn-primary">
                        <i class="fas fa-backward"></i> Volver
                    </a>
                    <button type="submit" name="btn" class="btn btn-info">
                        <i class="fas fa-save"></i> Actualizar
                    </button>
                    <button type="reset" class="btn btn-warning">
                        <i class="fas fa-paintbrush"></i> Limpiar
                    </button>
                </div>
            </form>
        </div>
        <script>
            document.getElementById("file").addEventListener("change", cambiarImagen);

            function cambiarImagen(event) {
                var file = event.target.files[0];
                var reader = new FileReader();
                reader.onload = (event) => {
                    document.getElementById("image").setAttribute("src", event.target.result)
                }
                reader.readAsDataURL(file);
            }
        </script>
    </body>

    </html>

<?php } ?>