<?php
// Iniciar sesión
session_start();

include '../../scripts/bd.php';
include('../../scripts/autentificador_usuario.php');

if (isset($_SESSION['usuario_seleccionado']) && $_SESSION['usuario_seleccionado'] !== '') {
    $idUsuario = $_SESSION['usuario_seleccionado'];
} else {
    $idUsuario = $_SESSION['usuario'];
}

// Preparar la declaración SQL para seleccionar la contraseña
$stmt = $conn->prepare('SELECT l.password FROM usuarios u JOIN logins l ON u.IdUsuario = l.idUsuarioFK WHERE u.IdUsuario = ?');
$stmt->bind_param('i', $idUsuario);
$stmt->execute();
$stmt->store_result();
// Verificar si se encontró el usuario
if ($stmt->num_rows > 0) {
    // Asociar los resultados de la consulta a variables
    $stmt->bind_result($passwordvieja);
    $stmt->fetch();

    // Limpiar y asignar valores a las variables
    $passwordnueva = trim(strip_tags(htmlentities($_POST["passwordnueva"])));
    $passwordconfirmacion = trim(strip_tags(htmlentities($_POST["confirmacion"])));
    $password = isset($_POST["password"]) ? trim(strip_tags(htmlentities($_POST["password"]))) : '';

    // Verificar si las contraseñas nuevas coinciden
    if ($passwordnueva === $passwordconfirmacion) {
        // Verificar si la nueva contraseña es la misma que la vieja
        if (password_verify($passwordnueva, $passwordvieja)) {
            $_SESSION['error'] = "La nueva contraseña no puede ser igual a la contraseña actual.";
            header('Location: /proyecto/views/perfil/cambio_contraseña.php');
            exit();
        }

        $hashed_pass = password_hash($passwordnueva, PASSWORD_DEFAULT);

        // Verificar si el usuario es administrador o si la contraseña vieja es correcta
        if (isset($_SESSION['panel_admin']) && $_SESSION['panel_admin'] == TRUE || password_verify($password, $passwordvieja)) {
            // Preparar la declaración SQL para actualizar la contraseña
            $stmt = $conn->prepare("UPDATE logins SET password = ? WHERE idUsuarioFK = ?");
            $stmt->bind_param("si", $hashed_pass, $idUsuario);
            
            if ($stmt->execute()) {
                $_SESSION['cambio'] = TRUE;
                header('Location: /proyecto/views/perfil/cambio_contraseña.php');
                exit();
            } else {
                $_SESSION['error'] = "Ha habido un error procesando la solicitud, escribe a soporte.";
                header('Location: /proyecto/views/perfil/cambio_contraseña.php');
                exit();
            }
        } else {
            $_SESSION['error'] = "La contraseña vieja es incorrecta.";
            header('Location: /proyecto/views/perfil/cambio_contraseña.php');
            exit();
        }
    } else {
        $_SESSION['error'] = "Las contraseñas no coinciden.";
        header('Location: /proyecto/views/perfil/cambio_contraseña.php');
        exit();
    }
} else {
    $_SESSION['error'] = "Usuario no encontrado.";
    header('Location: /proyecto/views/perfil/cambio_contraseña.php');
    exit();
}

// Cerrar la declaración y la conexión
$stmt->close();
$conn->close();
?>
