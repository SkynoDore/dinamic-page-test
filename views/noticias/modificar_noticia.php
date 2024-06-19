<?php
session_start();
include '../../scripts/bd.php';
include('../../scripts/autentificador_usuario.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idNoticia = $_POST['idNoticia'];
    $titulo = strip_tags($_POST['titulo']);
    $cuerpo = strip_tags($_POST['cuerpo']);
    $accion = $_POST['accion'];
    $fecha = date('Y-m-d H:i:s');

    // Inicializar la variable de error
    $_SESSION['error'] = '';

    // Verificar que los campos obligatorios no estén vacíos
    if (empty($titulo) || empty($cuerpo)) {
        $_SESSION['error'] .= "El título y el cuerpo de la noticia son obligatorios. ";
    }

    // Si la acción es eliminar
    if ($accion == 'eliminar') {
        // Eliminar la imagen del servidor
        $stmt = $conn->prepare("SELECT imagen FROM noticias WHERE idNoticia = ?");
        $stmt->bind_param("i", $idNoticia);
        $stmt->execute();
        $stmt->bind_result($imagenRuta);
        $stmt->fetch();
        $stmt->close();

        if (file_exists("../../$imagenRuta")) {
            unlink("../../$imagenRuta");
        }

        // Eliminar la noticia de la base de datos
        $stmt = $conn->prepare("DELETE FROM noticias WHERE idNoticia = ?");
        if ($stmt === false) {
            $_SESSION['error'] .= "Error en la preparación de la consulta: " . $conn->error . " ";
        } else {
            $stmt->bind_param("i", $idNoticia);

            // Ejecutar la declaración
            if ($stmt->execute()) {
                $_SESSION['cambio'] = TRUE;
                header('Location: /htdocs/views/noticias.php');
                exit();
            } else {
                $_SESSION['error'] .= "Error en la ejecución de la consulta: " . $stmt->error . " ";
            }

            $stmt->close();
        }
    } else { // Si la acción es actualizar
        $imagenRuta = null;

        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] !== UPLOAD_ERR_NO_FILE) {
            $error = $_FILES['imagen']['error'];

            if ($error === UPLOAD_ERR_OK) {
                // Verificar el tamaño del archivo (2MB = 2 * 1024 * 1024 bytes)
                $max_file_size = 2 * 1024 * 1024; // 2MB
                $pesoArchivo = filesize($_FILES['imagen']['tmp_name']);
                if ($pesoArchivo > $max_file_size) {
                    $_SESSION['error'] .= "El tamaño de la imagen no puede ser mayor a 2MB. ";
                }

                // Verificar el tipo de archivo
                $allowed_types = ['image/png', 'image/jpeg', 'image/jpg'];
                $file_type = $_FILES['imagen']['type'];
                if (!in_array($file_type, $allowed_types)) {
                    $_SESSION['error'] .= "Solo se permiten archivos PNG, JPEG y JPG. ";
                }

                if ($_SESSION['error'] === '') {
                    // Obtener la imagen antigua
                    $stmt = $conn->prepare("SELECT imagen FROM noticias WHERE idNoticia = ?");
                    $stmt->bind_param("i", $idNoticia);
                    $stmt->execute();
                    $stmt->bind_result($imagenAntigua);
                    $stmt->fetch();
                    $stmt->close();

                    $nombreImagen = uniqid() . "." . pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
                    $directorio = '../../imagenes/';
                    if (!is_dir($directorio)) {
                        mkdir($directorio, 0755, true);
                    }

                    if (move_uploaded_file($_FILES['imagen']['tmp_name'], $directorio . $nombreImagen)) {
                        $imagenRuta = "imagenes/$nombreImagen";

                        // Eliminar la imagen antigua del servidor
                        if (file_exists("../../$imagenAntigua")) {
                            unlink("../../$imagenAntigua");
                        }
                    } else {
                        $_SESSION['error'] .= "Error al mover la imagen subida. ";
                    }
                }
            } elseif ($error === UPLOAD_ERR_INI_SIZE) {
                $_SESSION['error'] .= "El tamaño del archivo excede el límite permitido por el servidor. ";
            }
        } else {
            // No se subió una nueva imagen, así que mantenemos la imagen actual
            $stmt = $conn->prepare("SELECT imagen FROM noticias WHERE idNoticia = ?");
            $stmt->bind_param("i", $idNoticia);
            $stmt->execute();
            $stmt->bind_result($imagenRuta);
            $stmt->fetch();
            $stmt->close();
        }

        // Si no hay errores, actualizar la noticia en la base de datos
        if ($_SESSION['error'] === '') {
            $stmt = $conn->prepare("UPDATE noticias SET titulo = ?, imagen = ?, cuerpo = ?, fecha = ? WHERE idNoticia = ?");
            if ($stmt === false) {
                $_SESSION['error'] .= "Error en la preparación de la consulta: " . $conn->error . " ";
            } else {
                $stmt->bind_param("ssssi", $titulo, $imagenRuta, $cuerpo, $fecha, $idNoticia);

                // Ejecutar la declaración
                if ($stmt->execute()) {
                    $_SESSION['cambio'] = TRUE;
                    header('Location: /htdocs/views/noticias.php');
                    exit();
                } else {
                    $_SESSION['error'] .= "Error en la ejecución de la consulta: " . $stmt->error . " ";
                }

                $stmt->close();
            }
        }
    }

    // Si hay errores, redirigir de nuevo a la página de noticias
    if ($_SESSION['error'] !== '') {
        header('Location: /htdocs/views/noticias.php');
        exit();
    }
} else {
    $_SESSION['error'] .= "Método de solicitud no válido. ";
    header('Location: /htdocs/views/noticias.php');
    exit();
}

$conn->close();
?>
