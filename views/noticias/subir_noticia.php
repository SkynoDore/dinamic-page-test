<?php
session_start();
include '../../scripts/bd.php';
include '../../scripts/autentificador_usuario.php';

$role = $_SESSION['role'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idUsuario = $_SESSION['usuario'];
    $titulo = strip_tags($_POST['titulo']);
    $cuerpo = strip_tags($_POST['cuerpo']);
    $fecha = date('Y-m-d H:i:s'); // Corregir la asignación de fecha

    // Inicializar la variable de error
    $_SESSION['error'] = '';

    // Verificar que los campos obligatorios no estén vacíos
    if (empty($titulo) || empty($cuerpo)) {
        $_SESSION['error'] .= "El título y el cuerpo de la noticia son obligatorios. ";
    }

    // Manejar la imagen
    if (isset($_FILES['imagen'])) {
        $error = $_FILES['imagen']['error'];

        if ($error === UPLOAD_ERR_OK) {
            // Obtener el tamaño del archivo utilizando filesize()
            $pesoArchivo = filesize($_FILES['imagen']['tmp_name']);

            // Verificar el tamaño del archivo (2MB = 2 * 1024 * 1024 bytes)
            $max_file_size = 2 * 1024 * 1024; // 2MB
            if ($pesoArchivo > $max_file_size) {
                $_SESSION['error'] .= "El tamaño de la imagen no puede ser mayor a 2MB. ";
            }

            // Verificar el tipo de archivo
            $allowed_types = ['image/png', 'image/jpeg', 'image/jpg'];
            $file_type = $_FILES['imagen']['type'];
            
            if (!in_array($file_type, $allowed_types)) {
                $_SESSION['error'] .= "Solo se permiten archivos PNG, JPEG y JPG. ";
            }

            // Si no hay errores de tamaño ni tipo, proceder con la subida y la inserción en la base de datos
            if ($_SESSION['error'] === '') {
                $nombreImagen = uniqid() . "." . pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);

                // Crear directorio si no existe
                $directorio = '../../imagenes/';
                if (!is_dir($directorio)) {
                    mkdir($directorio, 0755, true);
                }

                if (move_uploaded_file($_FILES['imagen']['tmp_name'], $directorio . $nombreImagen)) {
                    $rutaImagen = 'imagenes/' . $nombreImagen;

                    // Insertar la noticia en la base de datos
                    $stmt = $conn->prepare("INSERT INTO noticias (titulo, imagen, cuerpo, fecha, idUserFK) VALUES (?, ?, ?, ?, ?)");
                    if ($stmt === false) {
                        $_SESSION['error'] .= "Error en la preparación de la consulta: " . $conn->error . " ";
                    } else {
                        $stmt->bind_param("ssssi", $titulo, $rutaImagen, $cuerpo, $fecha, $idUsuario);

                        // Ejecutar la declaración
                        if ($stmt->execute()) {
                            // La inserción fue exitosa
                            $_SESSION['cambio'] = TRUE;
                            header('Location: /htdocs/views/noticias.php');
                            exit();
                        } else {
                            $_SESSION['error'] .= "Error en la ejecución de la consulta: " . $stmt->error . " ";
                        }

                        $stmt->close();
                    }
                } else {
                    $_SESSION['error'] .= "Error al mover la imagen subida. ";
                }
            }
        } elseif ($error === UPLOAD_ERR_INI_SIZE) {
            $_SESSION['error'] .= "El tamaño del archivo excede el límite permitido por el servidor. ";
        } else {
            $_SESSION['error'] .= "Error en la subida de la imagen. Código de error: $error";
        }
    } else {
        $_SESSION['error'] .= "No se ha subido ninguna imagen. ";
    }

    $conn->close();
}

// Redirigir a la página de noticias en caso de error o al finalizar
header('Location: /htdocs/views/noticias.php');
exit();
?>
