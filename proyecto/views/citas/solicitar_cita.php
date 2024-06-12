<?php
session_start();
include '../../scripts/bd.php';
include('../../scripts/autentificador_usuario.php');

$idUsuario = $_SESSION['usuario'];
$role = $_SESSION['role'];

// Obtener y validar los datos del formulario
$fecha_cita = $_POST["fecha_cita"];
$motivo_cita = trim(strip_tags(htmlentities($_POST["motivo_cita"])));

// Comprobar las fechas
$fecha_actual = new DateTime();
$fecha_cita_dt = new DateTime($fecha_cita);
$dias_diferencia = $fecha_actual->diff($fecha_cita_dt)->days;
$es_pasado = $fecha_cita_dt < $fecha_actual;
$es_dentro_de_un_dia = $dias_diferencia < 1;
$es_mas_de_20_dias = $dias_diferencia > 20;

// Validar las fechas
if ($es_pasado) {
    $_SESSION['error'] .= "No se puede hacer una cita en el pasado. ";
} elseif ($es_dentro_de_un_dia) {

    if ($_SESSION['role'] != 'admin'){

    
    $_SESSION['error'] .= "La cita tiene que ser pedida mínimo con 2 días de antelación. ";
} elseif ($es_mas_de_20_dias) {
    $_SESSION['error'] .= "La cita no puede ser pedida con más de 20 días de antelación. ";
}
}
if (!isset($_SESSION['error']) || $_SESSION['error'] === '') {
    // Preparar la declaración SQL para insertar la cita
    $stmt = $conn->prepare("INSERT INTO citas (idUsuarioFK, fecha_cita, motivo_cita) VALUES (?, ?, ?)");
    if ($stmt === false) {
        $_SESSION['error'] .= "Error en la preparación de la consulta: " . $conn->error . " ";
    } else {
        $stmt->bind_param("iss", $idUsuario, $fecha_cita, $motivo_cita);

        // Ejecutar la declaración
        if ($stmt->execute()) {
            // La inserción fue exitosa
            $_SESSION['cita'] = TRUE;
            header('Location: /proyecto/views/citaciones.php');
            exit();
        } else {
            $_SESSION['error'] .= "Error en la ejecución de la consulta: " . $stmt->error . " ";
        }

        $stmt->close();
    }
} else {
    header('Location: /proyecto/views/citaciones.php');
    exit();
}

$conn->close();
header('Location: /proyecto/views/citaciones.php');
exit();
?>
