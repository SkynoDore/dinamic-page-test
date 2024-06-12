<?php
session_start();
include '../../scripts/bd.php';

include('../../scripts/autentificador_usuario.php');

$action = $_POST['action'];
$idCita = $_POST['idCita'];

if ($action == 'update') {
    $fecha_cita = strip_tags(trim($_POST['fecha_cita']));
    $motivo_cita = strip_tags(trim($_POST['motivo_cita']));
    
    $stmt = $conn->prepare('UPDATE citas SET fecha_cita = ?, motivo_cita = ? WHERE IdCita = ?');
    $stmt->bind_param('ssi', $fecha_cita, $motivo_cita, $idCita);

    if ($stmt->execute()) {
        $_SESSION['cambio'] = TRUE;
    } else {
        $_SESSION['error'] = "Error al actualizar la cita.";
    }
} elseif ($action == 'delete') {
    $stmt = $conn->prepare('SELECT fecha_cita FROM citas WHERE IdCita = ?');
    $stmt->bind_param('i', $idCita);
    $stmt->execute();
    $stmt->bind_result($fecha_cita);
    $stmt->fetch();
    
    $date_diff = (new DateTime($fecha_cita))->diff(new DateTime())->days;

    if ($_SESSION['role'] != 'admin' && $date_diff <= 1) {
        $_SESSION['error'] = "No puede eliminar citas con menos de un día de anticipación.";
    } else {
        $stmt->close();
        $stmt = $conn->prepare('DELETE FROM citas WHERE IdCita = ?');
        $stmt->bind_param('i', $idCita);

        if ($stmt->execute()) {
            $_SESSION['cambio'] = TRUE;
        } else {
            $_SESSION['error'] = "Error al eliminar la cita.";
        }
    }
}

$stmt->close();
$conn->close();

header('Location: /proyecto/views/citaciones.php');
exit();
?>
