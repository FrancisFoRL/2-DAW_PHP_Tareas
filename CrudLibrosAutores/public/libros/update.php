<?php

require __DIR__ . "/../../vendor/autoload.php";

function mostrarError($nombre)
{
    if (isset($_SERVER[$nombre])) {
        echo "<p class='text-danger'>***{$_SERVER[$nombre]}</p>";
        unset($_SERVER[$nombre]);
    }
}

use Src\Autores;
use Src\Libros;
use Src\Tools;

if (!isset($_GET['id'])) {
    header("Location:index.php");
    die();
}

if (!Libros::exiteId($_GET['id'])) {
    header("Location:index.php");
    die();
}

$id = $_GET['id'];
$libro = (new Libros)->setId($id)->read();
$categorias = Libros::getCategorias();
$autores = Autores::readAll(1);

if (isset($_POST['btn'])) {
    $error = false;
    $nombre = trim(ucwords($_POST['nombre']));
    $isbn = trim($_POST['isbn']);
    $categoria = $_POST['categoria'];
    $autor = $_POST['autor'];
    $descripcion = trim(ucwords($_POST['descripcion']));

    if (strlen($nombre) <= 0) {
        $error = true;
        $_SESSION['nombre'] = "El nombre no puede estar vacio";
    }

    if (strlen($isbn) <= 0) {
        $error = true;
        $_SESSION['isbn'] = "El isbn no puede estar vacio";
    }

    if (strlen($descripcion) <= 0) {
        $error = true;
        $_SESSION['descripcion'] = "*** La descripcion no puede estar vacia";
    }

    $patron = '/\b(?:ISBN(?:: ?| ))?((?:97[89])?\d{9}[\dx])\b/i';
    if (!preg_match($patron, $isbn)) {
        $error = true;
        $_SESSION['isbn'] = "El formato del ISBN no es correcto";
    }

    if ($error == true) {
        header("Location:{$_SERVER['PHP_SELF']}?id=$id");
        die();
    }

    $nombreImagen = $libro->portada;
    if ($_FILES['portada']['error'] == 0) {
        $images = Tools::getImages();
        if (!in_array($_FILES['portada']['type'], $images)) {
            $_SESSION['portada'] = "*** El formato del archivo no es valido";
            header("Location:{$_SERVER['PHP_SELF']}?id=$id");
        }
        $nombreImagen = "/img/libros/" . uniqid() . "_libroPortada.png";
        if (!move_uploaded_file($_FILES['portada']['tmp_name'], "./.." . $nombreImagen)) {
            $nombreImagen = '/img/libros/default.png';
        } else {
            if (basename($libro->portada) != "default.png") {
                unlink("./../." . $libro->portada);
            }
        }
    }

    (new Libros)
        ->setNombre($nombre)
        ->setIsbn($isbn)
        ->setCategoria($categoria)
        ->setDescripcion($descripcion)
        ->setPortada($nombreImagen)
        ->setAutor_id($autor)
        ->update($id);
    $_SESSION['mensaje'] = "Libro actualizado";
    header("Location: index.php");
} else {

?>

    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Editar Libro</title>
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
        <h5 class="text-center mt-4 bolder fw-bold">Editar Libro</h5>
        <div class="container">
            <form name="a" action="<?php echo $_SERVER['PHP_SELF'] . "?id=$id" ?>" method="POST" enctype="multipart/form-data" class="py-4 px-4 mx-auto text-light bg-dark rounded" style="width: 50rem;">
                <div class="row mt-4">
                    <div class="col">
                        <label for="n">Nombre</label>
                        <input type="text" class="form-control" placeholder="Nombre" name="nombre" value="<?php echo $libro->nombre ?>">
                    </div>
                    <?php
                    mostrarError("nombre");
                    ?>
                    <div class="col">
                        <label for="n">ISBN</label>
                        <input type="text" class="form-control" placeholder="ISBN" name="isbn" value="<?php echo $libro->isbn ?>">
                    </div>
                    <?php
                    mostrarError("isbn");
                    ?>
                </div>
                <div class="row mt-4">
                    <div class="col">
                        <label for="n">Categoria</label>
                        <select name="categoria" class="form-select">
                            <?php
                            foreach ($categorias as $categoria) {
                                $opcion = ($libro->categoria == $categoria) ? "selected" : "";
                                echo "<option $opcion>$categoria</option>";
                            }
                            ?>

                        </select>
                    </div>
                    <?php
                    mostrarError("tipo");
                    ?>
                    <div class="col">
                        <label for="n">Autor</label>
                        <select name="autor" class="form-select">
                            <?php
                            foreach ($autores as $autor) {
                                $opcion = ($libro->autor_id == $autor->id) ? "selected" : "";
                                echo "<option value='{$autor->id}' $opcion>{$autor->nombre}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <?php
                    mostrarError("autor_id");
                    ?>


                    <div class="mt-4">
                        <label for="n">Descripcion</label>
                        <div class="col">
                            <textarea class="form-control" placeholder="Descripción" id="floatingTextarea2" name="descripcion" style="height: 100px" maxlength="400"><?php echo $libro->descripcion ?></textarea>
                        </div>
                    </div>
                    <?php
                    mostrarError("descripcion");
                    ?>
                    <div class="mt-4">
                        <label for="n">Portada Libro</label>
                        <div class="input-group">
                            <input type="file" class="form-control" id="file" name="portada">
                        </div>
                    </div>
                    <?php
                    mostrarError("portada");
                    ?>
                    <div class="mt-4 text-center">
                        <img class="img-thumbnail" src="./../<?php echo $libro->portada ?>" id="image" style="width: 10rem; height: 10rem;">
                    </div>
                    <div class="mt-4">
                        <a href="index.php" class="btn btn-primary">
                            <i class="fas fa-backward"></i> Volver
                        </a>
                        <button type="submit" name="btn" class="btn btn-info">
                            <i class="fas fa-save"></i> Guardar
                        </button>
                        <button type="reset" class="btn btn-warning">
                            <i class="fas fa-paintbrush"></i> Limpiar
                        </button>
                    </div>
                </div>
            </form>
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