<?php
session_start();

include '../../scripts/bd.php';

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Array para almacenar los errores
$errors = array();


// Obtener y sanear los datos del formulario
$user = trim(strip_tags(htmlentities($_POST['usuario'])));
$nombre = trim(strip_tags(htmlentities($_POST['nombre'])));
$apellidos = trim(strip_tags(htmlentities($_POST['apellidos'])));
$email = trim(strip_tags(htmlentities($_POST['email'])));
$pass = trim(strip_tags(htmlentities($_POST['password'])));
$pass2 = trim(strip_tags(htmlentities($_POST['password2'])));
$telefono = trim(strip_tags(htmlentities($_POST['telefono'])));
$fecha_nacimiento = trim(strip_tags(htmlentities($_POST['fecha_nacimiento'])));
$direccion = trim(strip_tags(htmlentities($_POST['direccion'])));
$sexo = trim(strip_tags(htmlentities($_POST['sexo'])));

$fecha_alta = date('Y-m-d');

$fecha_login = date('Y-m-d H:i:s'); //devolvera algo como 2024-05-30 17:12:34

// Asignar el rol en función del rol del usuario que está creando la cuenta
if (!isset($_SESSION['role']) || (isset($_SESSION['role']) && $_SESSION['role'] !== 'admin')) {
    $role = 'usuario';
} else {
    // Verificar si el rol se envía desde el formulario
    $role = isset($_POST['role']) ? $_POST['role'] : 'usuario';
}


// Validar longitud de usuario y contraseña
if (strlen($user) < 3 || strlen($user) > 12 || !preg_match("/^[a-zA-Z0-9_]+$/", $user)) {
    $errors[] = "El nombre de usuario debe tener entre 3 y 12 caracteres y solo puede contener letras, números y guiones bajos.";
}

if (strlen($pass) < 8 || !preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/", $pass)) {
    $errors[] = "La contraseña debe tener mínimo 8 caracteres, al menos una letra mayúscula y un número.";
}

if ($pass !== $pass2) {
    $errors[] = "Las contraseñas no coinciden.";
}

// Obtener la fecha actual
$fecha_actual = date('Y-m-d');

// Restar 100 años a la fecha actual
$fecha_minima = date('Y-m-d', strtotime('-100 years'));

// Validar la fecha de nacimiento
if ($fecha_nacimiento > $fecha_actual) {
    $errors[] = "La fecha de nacimiento no puede ser en el futuro.";
} elseif ($fecha_nacimiento < $fecha_minima) {
    $errors[] = "La fecha de nacimiento no puede ser más de 100 años en el pasado.";
}

/// Verificar si el correo y el usuario ya están en uso
$stmt1 = $conn->prepare("SELECT * FROM usuarios WHERE email = ?");
$stmt1->bind_param("s", $email);
$stmt1->execute();
$result1 = $stmt1->get_result();

$stmt2 = $conn->prepare("SELECT * FROM logins WHERE usuario = ?");
$stmt2->bind_param("s", $user);
$stmt2->execute();
$result2 = $stmt2->get_result();

if ($result1->num_rows > 0 || $result2->num_rows > 0) {
    $errors[] = "El nombre de usuario o correo electrónico ya están en uso.";
}

// Si hay errores, redirigir de vuelta a la página de registro y mostrar advertencia por JavaScript
if (!empty($errors)) {
    echo "<script>alert('Se encontraron los siguientes errores:\\n";
    foreach ($errors as $error) {
        echo "- $error\\n";
    }
    echo "'); window.location.href = '/dinamic-page-test/views/pagina_registro.php';</script>";
    exit();
}

// Hash de la contraseña
$hashed_pass = password_hash($pass, PASSWORD_DEFAULT);

// Preparar la declaración SQL
$stmt = $conn->prepare("INSERT INTO usuarios (nombre, apellidos, email, telefono, fecha_nacimiento, fecha_alta, direccion, sexo) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssss", $nombre, $apellidos, $email, $telefono, $fecha_nacimiento, $fecha_alta, $direccion, $sexo);

// Ejecutar la declaración
if ($stmt->execute()) {

    if (!isset($_SESSION['valido'])){
    session_regenerate_id();
    $_SESSION['valido'] = TRUE;
    $_SESSION['nombre'] = $nombre;
    $_SESSION['role'] = $role;
    }
    
        // Obtener el ID del usuario insertado
        $idUsuario = $stmt->insert_id;

       // Insertar en la tabla logins
    $stmt = $conn->prepare("INSERT INTO logins (idUsuarioFK, fecha_login, usuario, password, role) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $idUsuario, $fecha_login, $user, $hashed_pass, $role);
    // Ejecutar la declaración
    if ($stmt->execute()) {
        if (!isset($_SESSION['usuario'])){
        $_SESSION['usuario'] = $idUsuario;
        }
        // La inserción fue exitosa
    } else {
        echo "Ha habido un error, escribir a soporte"; //. $stmt->error;
    }
    if ($_SESSION['panel_admin'] == TRUE){
        header('Location: /dinamic-page-test/views/admin_usuarios.php');
        $_SESSION['cambio'] = TRUE;
        exit();
    } else {
        header('Location: /dinamic-page-test/index.php');
        exit();
    }
    
} else {
    echo "Ha habido un error, escribir a soporte"; //. $stmt->error;
}

// Cerrar la conexión
$stmt->close();
$conn->close();
?>
