<?php
// Se inicia sesión porque en esta página no hay barra
session_start();

include '../../scripts/bd.php';

include('../../scripts/autentificador_usuario.php');

$idUsuario = $_SESSION['usuario'];

// Obtener y sanitizar los datos del formulario
$nombre = strip_tags(trim($_POST['nombre']));
$apellidos = strip_tags(trim($_POST['apellidos']));
$email = strip_tags(trim($_POST['email']));
$direccion = strip_tags(trim($_POST['direccion']));
$sexo = strip_tags(trim($_POST['sexo']));
$telefono = strip_tags(trim($_POST['telefono']));
$password = strip_tags(trim($_POST['password']));

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

if (isset($_SESSION['panel_admin']) && $_SESSION['panel_admin'] == TRUE) {
    $stmt->close(); // Cerrar la declaración anterior antes de reutilizar
    $stmt = $conn->prepare('UPDATE usuarios SET nombre = ?, apellidos = ?, email = ?, direccion = ?, sexo = ?, telefono = ? WHERE IdUsuario = ?');
    $stmt->bind_param('ssssssi', $nombre, $apellidos, $email, $direccion, $sexo, $telefono, $idUsuario);
    
        if ($stmt->execute()) {
            $_SESSION['cambio'] = TRUE;
            header('Location: /proyecto/views/perfil.php');
            exit();
        } else {
            echo "Error al actualizar los datos del usuario.";
        }
     }
     else{
    // Verificar la contraseña actual
    if (password_verify($password, $passwordvieja)) {
        // Preparar la declaración SQL para actualizar los datos del usuario
        $stmt->close(); // Cerrar la declaración anterior antes de reutilizar
        $stmt = $conn->prepare('UPDATE usuarios SET nombre = ?, apellidos = ?, email = ?, direccion = ?, sexo = ?, telefono = ? WHERE IdUsuario = ?');
        $stmt->bind_param('ssssssi', $nombre, $apellidos, $email, $direccion, $sexo, $telefono, $idUsuario);
        
        if ($stmt->execute()) {
            $_SESSION['cambio'] = TRUE;
            header('Location: /proyecto/views/perfil.php');
            exit();
        } else {
            echo "Error al actualizar los datos del usuario.";
        }
    } else {
        $_SESSION['error'] .= "No se ha realizado ningún cambio, la contraseña es incorrecta. ";
        header('Location: /proyecto/views/perfil.php');
        exit();
    }}
} else {
    $_SESSION['error'] .= "No se ha realizado ningún cambio, usuario no encontrado. ";
    header('Location: /proyecto/views/perfil.php');
    exit();
}

// Cerrar la declaración y la conexión
$stmt->close();
$conn->close();
?>