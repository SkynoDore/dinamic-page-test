<?php
include '../config.php';
session_start();
include '../scripts/bd.php';
include('../scripts/autentificador_usuario.php');

$idUsuario = $_SESSION['usuario'];
$role = $_SESSION['role'];

// Obtener la lista de usuarios si es administrador
if ($role == 'admin') {
    $userStmt = $conn->prepare('SELECT DISTINCT idUsuarioFK, usuario FROM logins');
    $userStmt->execute();
    $userStmt->store_result();
    $userStmt->bind_result($userId, $userName);

    $users = [];
    while ($userStmt->fetch()) {
        $users[] = ['id' => $userId, 'name' => $userName];
    }
    $userStmt->close();
}

// Consulta para obtener citas
if ($role == 'admin') {
    $stmt = $conn->prepare('SELECT idCita, fecha_cita, motivo_cita, idUsuarioFK FROM citas');
} else {
    $stmt = $conn->prepare('SELECT idCita, fecha_cita, motivo_cita FROM citas WHERE idUsuarioFK = ?');
    $stmt->bind_param('i', $idUsuario);
}
$stmt->execute();
$stmt->store_result();

if ($role == 'admin') {
    $stmt->bind_result($idCita, $fecha_cita, $motivo_cita, $userId);
} else {
    $stmt->bind_result($idCita, $fecha_cita, $motivo_cita);
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="Author" CONTENT="Gabriel Vich">
    <meta name="description" content="Contacto">
    <meta name="category" content="Bar">
    <link rel="icon" type="image/jpg" href="../photos/favicon.ico">
    <link rel="stylesheet" href="../style/main.css">
    <script src="../bootstrap-5.3.2-dist/js/bootstrap.min.js"></script>
    <title>Citas ohnigiri</title>
<script src="../scripts/toggleForm.js"></script>
</head>
<body>
    <?php include('../scripts/selector_de_barras.php'); ?>

    <main>
        <section><div class="container bg-light">
        <?php
                include('../scripts/mensaje_cambio.php');
                 ?>
        <div class="container pt-2"><h1>Gestor de citas</h1>
        <p class="text-center">Aquí puedes solicitar una cita, modificarlas o borrarlas.</p></div>

        <?php if ($role != 'admin') { ?>
        <div class="container bg-light py-5">
            <h2>Solicitar cita</h2>
            <form action="/dinamic-page-test/views/citas/solicitar_cita.php" method="post">
                <div class="form-group">
                    <label for="fecha_cita">Fecha cita</label>
                    <input class="form-control" type="date" id="fecha_cita" name="fecha_cita" required>
                </div>
                <div class="form-group">
                    <label for="motivo_cita">Motivo cita</label>
                    <input class="form-control" type="text" id="motivo_cita" name="motivo_cita" placeholder="Aquí pon el motivo de tu cita" required>
                </div>
                <hr>
                <label for="privacidad">Acepta nuestra <a href="#">política de privacidad?</a></label>
                <input type="checkbox" id="privacidad" name="privacidad" required>
                <button class="btn btn-secondary" type="submit" id="enviar">Enviar</button>
                <button class="btn btn-secondary" type="reset">Borrar</button>
            </form>
        </div>
        <hr>
        <?php } ?>

        <?php if ($role == 'admin') { ?>
        <div class="container bg-light py-5">
            <h2>Asignar cita</h2>
            <form method="post" action="/dinamic-page-test/views/citas/solicitar_cita.php" class="p-3 my-3">
                <label for='user_id'>Usuario:</label>
                <select class="form-control" id="user_id" name="user_id" required>
                    <?php foreach ($users as $user) { ?>
                        <option value="<?php echo htmlspecialchars($user['id']); ?>"><?php echo htmlspecialchars($user['name']); ?></option>
                    <?php } ?>
                </select><br>
                <label for='fecha_cita'>Fecha de la cita:</label>
                <input class="form-control" type="date" id="fecha_cita" name="fecha_cita" required><br>
                <label for='motivo_cita'>Motivo de la cita:</label>
                <input class="form-control" type="text" id="motivo_cita" name="motivo_cita" required><br>
                <button class="btn btn-outline-primary" type='submit'>Asignar Cita</button>
            </form>
        </div>
        <hr>
        <?php } ?>

        <h2>Citas solicitadas</h2>
        <div class="container bg-light py-5">
            <?php
            if ($stmt->num_rows > 0) {
                while ($stmt->fetch()) {
                    $formatted_date = (new DateTime($fecha_cita))->format('d/m/Y');
                    if ($role == 'admin') {
                        $userStmt = $conn->prepare('SELECT DISTINCT l.usuario, u.nombre FROM logins l JOIN usuarios u ON u.IdUsuario = l.idUsuarioFK WHERE idUsuario = ?');
                        $userStmt->bind_param('i', $userId);
                        $userStmt->execute();
                        $userStmt->bind_result($userName, $realName);
                        $userStmt->fetch();
                        $userStmt->close();
                    }
            ?>
            <!-- texto plano no modificable-->
            <div class="m-2 mx-auto d-flex justify-content-center">
                <div class="form-info" id="form_info-<?php echo $idCita?>">
                    <p>Cita #<?php echo $idCita?><br>
                    <?php if ($role == 'admin') { ?>
                    Usuario: <?php echo htmlspecialchars($userName); ?><br>
                    Nombre: <?php echo htmlspecialchars($realName); ?><br>
                    <?php } ?>
                    Fecha de la cita: <?php echo htmlspecialchars($formatted_date); ?><br>
                    Motivo de la cita: <?php echo htmlspecialchars($motivo_cita); ?></p>
                </div>
                <!-- texto modificable tras haber presionado el botón-->
                <div class="form-container" id="form-<?php echo $idCita?>">
                    <form method="post" action="citas/actualizar_cita.php" class="p-3 my-3">
                        <label for='fecha_cita'>Fecha de la cita:</label>
                        <input class="form-control" type="date" id="fecha_cita" name="fecha_cita" value='<?php echo htmlspecialchars($fecha_cita); ?>' required><br>
                        <label for='motivo_cita'>Motivo de la cita</label>
                        <input class="form-control" type="text" id="motivo_cita" name="motivo_cita" value='<?php echo htmlspecialchars($motivo_cita); ?>' required><br>
                        <input type="hidden" name="idCita" value='<?php echo $idCita; ?>'>
                        <button class="btn btn-outline-primary" type='submit' name='action' value='delete'>Eliminar</button>
                        <button class="btn btn-outline-primary" type='submit' name='action' value='update'>Actualizar</button>
                    </form>
                </div>
                <button class="btn btn-secondary" type='button' onclick="toggleForm(<?php echo $idCita?>)">Modificar</button>
            </div>
            <hr>
            <?php
                }
            } else {
                echo "No se encontraron citas.";
            }
            $stmt->close();
            $conn->close();
            ?>
        </div>
        </div></section>
    </main>
    <?php include 'barras/footer.php' ?>
</body>
</html>
